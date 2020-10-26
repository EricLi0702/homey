<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5">
                <h2 class="p-3">Register New Notification</h2>
                <Form :model="registerNotificationData">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 mb-3 ">
                            <p>Title</p>
                            <Input v-model="registerNotificationData.title" placeholder="please enter user name" />
                        </div>
                        <div class="col-md-6 mb-3 ">
                            <p>Type</p>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="common" v-model="registerNotificationData.type">
                                    <Icon size="35" type="md-hand" color="#BFD23A"/>
                                    <span style="color:#BFD23A">Common</span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="urgent" v-model="registerNotificationData.type">
                                    <Icon size="35" type="md-stopwatch" color="#F4B894" />
                                    <span style="color:#F4B894">Urgent</span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="important" v-model="registerNotificationData.type">
                                    <Icon size="35" type="ios-warning-outline" color="#F26A5A" />
                                    <span style="color:#F26A5A">Important</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="">Period</p>
                            <RadioGroup @on-change="setPeriodToBlank" v-model="periodType" class="">
                                <Radio label="withPeriod">Choose Period</Radio>
                                <Radio label="withCalendar">Choose period with calendar</Radio>
                            </RadioGroup>   

                            <DatePicker v-if="periodType == 'withCalendar' " class="w-50 mx-auto"  type="daterange" @on-change="notiDateChange" placeholder="please select the date" style="display: block" placement="bottom-end"></DatePicker>
                            <RadioGroup v-else v-model="initPeriod" class=" w-50 mx-auto d-flex justify-content-between">
                                <Radio label="forever">Forever</Radio>
                                <Radio label="week">One week</Radio>
                                <Radio label="month">One month</Radio>
                            </RadioGroup> 
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="registerNotificationData.desc" placeholder="please enter description" />
                        </div>
                        <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
                            <Icon class="pr-2 noti-upload-icons" size="25" type="ios-image" />
                            <Icon class="pr-2 noti-upload-icons" size="25" type="ios-folder" />
                            <Icon class="pr-2 noti-upload-icons" size="25" type="ios-film" />
                            <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                            <div class="emoji-area-popup">
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                            </div>
                            <Button class="ml-auto" @click="registerNotification" :disabled="isRegistering" :loading="isRegistering">something</Button>
                        </div>
                    </div>
                </Form> 
            </div>
        </div>
    </div>
</template>

<script>
//
import wysiwyg from "vue-wysiwyg"
//emoji
import { Picker } from 'emoji-mart-vue'
//import Api
import {getNotificationList,registerNotification,updateNotification,delNotification} from '~/api/notification'

export default {
    middleware: 'auth',

    components: {
        Picker,     //emoji
    },

    data(){
        return{
            baseUrl:window.base_url,
            registerNotificationData: {
                title: '',
                desc: '',
                period: '',
                type: ['common'],
            },
            //vueEditor
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"]
            ],

            //emoji
            emoStatus:false,

            initPeriod:'forever',
            periodType:'withPeriod',
            isRegistering:false,
            typeOfData:[],
        }
    },

    methods:{
        toggleEmo(){
            this.emoStatus = !this.emoStatus;
        },
        onInput(e){
            if(!e){
                return false;
            }
            if(!this.registerNotificationData.desc){
                this.registerNotificationData.desc = e.native
            }else{
                this.registerNotificationData.desc = this.registerNotificationData.desc + e.native
            }
        },

        notiDateChange(date){
            this.registerNotificationData.period = date;
        },

        setPeriodToBlank(){
            this.registerNotificationData.period = '';
        },

        async registerNotification(){
            if(this.registerNotificationData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.registerNotificationData.type.length == 0){
                return this.error('Type is required')
            }
            if(this.periodType == 'withPeriod'){
                this.registerNotificationData.period = this.initPeriod;
                if(this.registerNotificationData.period.trim() == ''){
                    return this.error('Period is required')
                }
            }
            else{
                if(this.registerNotificationData.period.length == 0){
                    return this.error('Period is required')
                }
            }
            if(this.registerNotificationData.desc.trim() == ''){
                return this.error('Description is required')
            }
            console.log(this.registerNotificationData);
            this.isRegistering = true;

            await registerNotification(this.registerNotificationData)
            .then(res=>{
                console.log(res);
            })
            .catch(err=>{
                console.log(err);
            })
            this.isRegistering = false
        },
    }
}
</script>