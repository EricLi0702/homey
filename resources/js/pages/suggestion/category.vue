<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Request repair</p>
                    <Badge type="normal" :count="17"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Fix Problem</p>
                    <Badge type="normal" :count="5"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Covid</p>
                    <Badge type="normal" :count="23"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Health</p>
                    <Badge type="normal" :count="56"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Children</p>
                    <Badge type="normal" :count="19"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Food</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                Importantance on this week
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item">
                    <p>Repair Lamps</p>
                    <Progress class="w-100" :percent="45" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Look up broken equipment</p>
                    <Progress class="w-100" :percent="78" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="96" :stroke-width="20" stroke-color="#04619F" status="active" text-inside />
                </div>
                <div class=" ccl-item ">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="63" :stroke-width="20" stroke-color="#000000" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="89" :stroke-width="20" stroke-color="#737375" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="23" :stroke-width="20" stroke-color="#F6684E" status="active" text-inside />
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                My Activity Thread
            </div>
            <div class="community-category-list p-3">
                <div v-for="suggestion in suggestionData" :key="suggestion.id" >
                    <div class=" ccl-item d-flex justify-content-between">
                        <router-link :to="{path:`/notification/${suggestion.id}`}">
                            <p>{{suggestion.title}}</p>
                        </router-link>
                    </div>
                    <Divider />
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {getTop5Suggestion} from '~/api/suggestion'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            suggestionData:[]
        }
    },
    computed:{
        ...mapGetters({
        currentUser:'auth/user'
        })
    },
    async mounted(){
        getTop5Suggestion(this.currentUser.id).then(res=>{
            this.suggestionData = res.data
        }).catch(err=>{
            console.log(err)
        })
    }
}
</script>