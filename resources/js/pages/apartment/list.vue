<template>
    <div class="m-2 py-5">
        <Button class="mb-4" type="info" size="small" @click="addApt">Add Apartment</Button>
        <Table :loading="aptLists.length == 0"  border :columns="columns2" :data="aptLists"></Table>
    </div>
</template>

<script>
import {getAptLists,delApt} from '~/api/apartment'
export default {
    data(){
        return{
            aptLists:[],
            isAdding:false,
            isDeleting:false,
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
                                    type: 'primary',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.editApt(params.index)
                                    }
                                }
                            }, this.$i18n.t('apartment').edit),
                            h('Button', {
                                props: {
                                    type: 'error',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.delApt(params.index)
                                    }
                                }
                            }, this.$i18n.t('apartment').delete),
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
                            
                        ]);
                    }
                }
            ]
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
        delApt(index){
            let apt = this.aptLists[index];
            this.isDeleting = true
            delApt(apt)
                .then(res=>{
                    this.success('successfully deleted')
                    this.aptLists.splice(index,1)
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isDeleting = false
        },
        registerSuperMng(index){
            let apt = this.aptLists[index];
            this.$router.push({name:'apartment.superManager',params:{aptData:apt}})
        },

        // registerBuilding(apt){
        //     this.$router.push({name:'apartment.building',params:{aptData:apt}})
        // }
    }
}
</script>

<style>

</style>