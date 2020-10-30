<template>
    <Breadcrumb separator="<b class='demo-breadcrumb-separator'>/</b>">
        <BreadcrumbItem to="/">Home</BreadcrumbItem>
        <BreadcrumbItem :to="currentPath.matched[0].path">{{pathFirst}}</BreadcrumbItem>
        <BreadcrumbItem :to="currentPath.matched[1].path">{{pathSecond}}</BreadcrumbItem>
    </Breadcrumb>
</template>
<script>
export default {
    data(){
        return{
            pathFirst:'',
            pathSecond:'',
        }
    },
    computed:{
        currentPath(){
            return this.$route;
        }
    },
    mounted(){
        if(this.currentPath.matched[0].path){
            let path = this.currentPath.path.split('/')
            this.pathFirst = path[1]
        }else{
            this.pathFirst = ''
        }
        if(this.currentPath.matched[1].path){
            let path = this.currentPath.path.split('/')
            this.pathSecond = path[2]
        }else{
            this.pathSecond = ''
        }
    },
    watch:{
        currentPath:{
            handler(val){
                if(val.matched[0].path){
                    let path = val.path.split('/')
                    this.pathFirst = path[1]
                }else{
                    this.pathFirst = ''
                }
                if(val.matched[1].path){
                    let path = val.path.split('/')
                    this.pathSecond = path[2]
                }else{
                    this.pathSecond = ''
                }
            },
            deep:true
        }
    }
}
</script>
<style>
    .demo-breadcrumb-separator{
        color: #b3b3b3;
        padding: 0 5px;
    }
</style>