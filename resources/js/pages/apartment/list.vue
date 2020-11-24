<template>
    <div class="m-2 py-5">
        <Button class="mb-4" type="info" size="small" @click="addApt">Add Apartment</Button>
        <Table :loading="aptLists.length == 0"  border :columns="columns2" :data="aptLists"></Table>
        <Modal v-model="removeModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span v-if="deleteAptData != null">{{$t('modal').delete}} : {{deleteAptData.aptName}}</span>
            </p>
            <div class="text-center">
                <p>{{$t('modal').willDeleteAPT}}</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" @click="delApt()">{{ $t('apartment').delete }}</Button>
            </div>
        </Modal>
    </div>
</template>

<script>

import { locale } from 'view-design';
import en from 'view-design/dist/locale/en-US';
import ko from 'view-design/dist/locale/ko-KR';
import vn from 'view-design/dist/locale/vi-VN';

import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
import {getAptLists,delApt} from '~/api/apartment'
export default {
    data(){
        return{
            aptLists:[],
            isAdding:false,
            isDeleting:false,
            deleteAptData:null,
            removeModal:false,

            columns2: [
                {
                    title: this.$i18n.t('apartment').AptName,
                    key: 'aptName',
                    width: 150,
                    fixed: 'left'
                },
                {
                    title: this.$i18n.t('apartment').aptCode,
                    key: 'code',
                    width: 150
                },
                {
                    title: this.$i18n.t('apartment').address,
                    key: 'address',
                    width: 200
                },
                {
                    title: this.$i18n.t('apartment').representativeName,
                    key: 'repreName',
                    width: 150
                },
                {
                    title: this.$i18n.t('apartment').phoneNumber,
                    key: 'phoneNumber',
                    width: 150
                },
                {
                    title: this.$i18n.t('apartment').eMail,
                    key: 'email',
                    width: 150
                },
                {
                    title: this.$i18n.t('apartment').action,
                    key: 'action',
                    fixed: 'right',
                    width: 300,
                    render: (h, params) => {
                        return h('div', [
                            h('Button', {
                                props: {
                                    type: 'success',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.registerSuperMng(params.index)
                                    }
                                }
                            }, this.$i18n.t('apartment').registerSuperManager),

                            h('Icon', {
                                props: {
                                    type: 'md-create',
                                    size: '25',
                                    color: '#44B4E2'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.editApt(params.index)
                                    }
                                }
                            }),
                            h('Icon', {
                                props: {
                                    type: 'ios-trash',
                                    size: '25',
                                    color: '#FD0000'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.openRemoveModal(params.index)
                                        // this.delApt(params.index)
                                    }
                                }
                            }),
                            
                            
                        ]);
                    }
                }
            ]
        }
    },

    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user',
            currentLang:'lang/locale'
        }),
    },

    watch:{
        currentLang:{
            handler(val){
                if(val == 'en'){
                    locale(en);
                }
                if(val == 'kr'){
                    locale(ko);
                }
                if(val == 'vn'){
                    locale(vn);
                }
            },
            deep:true
        }
    },

    created(){
        if(this.currentLang == 'en'){
            locale(en);
        }
        if(this.currentLang == 'kr'){
            locale(ko);
        }
        if(this.currentLang == 'vn'){
            locale(vn);
        }
    },

    mounted(){
        getAptLists()
        .then(res=>{
                this.aptLists = res.data
            })
            .catch(err=>{
                console.log(err)
            })
    },
    methods:{
        addApt(){
            this.$router.push({path:'register'})
        },
        editApt(index){
            let apt = this.aptLists[index];
            this.$router.push({name:'apartment.details',params:{addData:apt}})
        },

        openRemoveModal(index){
            this.deleteAptData = this.aptLists[index];
            this.removeModal = true;
        },

        delApt(){
            this.isDeleting = true
            delApt(this.deleteAptData)
                .then(res=>{
                    this.removeModal = false;
                    this.isDeleting = false;
                    this.aptLists.pop(this.deleteAptData);
                    this.deleteAptData = null;
                    this.success(i18n.t('alert').removeSuccessfully);
                })
                .catch(err=>{
                    console.log(err)
                })
        },
        registerSuperMng(index){
            let apt = this.aptLists[index];
            this.$router.push({name:'apartment.superManager',params:{aptData:apt}})
        },
    }
}
</script>

<style>

</style>