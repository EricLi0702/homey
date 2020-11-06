<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>1. Notice to Pay or Quit</p>
                    <Badge type="normal" :count="17"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>2. Notice to Cure or Quit</p>
                    <Badge type="normal" :count="5"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>3. Unconditional Quit Notice</p>
                    <Badge type="normal" :count="23"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>4. Notice of Transfer of Ownership/Management</p>
                    <Badge type="normal" :count="56"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>5. Notice of Non-Renewal</p>
                    <Badge type="normal" :count="19"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>6. Notice of Rent Increase</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                Importantance on this month
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item">
                    <p>Architecture.</p>
                    <Progress class="w-100" :percent="45" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>House.</p>
                    <Progress class="w-100" :percent="78" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Property.</p>
                    <Progress class="w-100" :percent="96" :stroke-width="20" stroke-color="#04619F" status="active" text-inside />
                </div>
                <div class=" ccl-item ">
                    <p>Real Estate.</p>
                    <Progress class="w-100" :percent="63" :stroke-width="20" stroke-color="#000000" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Residence.</p>
                    <Progress class="w-100" :percent="89" :stroke-width="20" stroke-color="#737375" status="active" text-inside />
                </div>
                <!-- <div class=" ccl-item">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="23" :stroke-width="20" stroke-color="#F6684E" status="active" text-inside />
                </div> -->
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                My Activity Thread
            </div>
            <div class="community-category-list p-3">
                <div v-for="notification in notificationData" :key="notification.id" >
                    <div class=" ccl-item d-flex justify-content-between">
                        <router-link :to="{path:`/notification/${notification.id}`}">
                            <p>{{notification.title}}</p>
                        </router-link>
                    </div>
                    <Divider />
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {getTop5Notification} from '~/api/notification'
export default {
    data(){
        return{
            notificationData:[],
        }
    },
    computed:{
    ...mapGetters({
      currentUser:'auth/user'
    })
    },
    async mounted(){
        console.log('++++notification+++',this.currentUser)
        await getTop5Notification(this.currentUser.id).then(res=>{
            console.log('----res',res)
            this.notificationData = res.data
        }).catch(err=>{
            console.log(err)
        })
    },
}
</script>