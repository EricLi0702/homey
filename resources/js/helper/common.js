import {mapGetters,mapActions} from 'vuex';
export default{
    data(){
        return{

        }
    },
    methods:{
        async callApi(method,url,dataObj){
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                })
            } catch (e) {
                return e.response
            }
        },
        
        success (nodesc) {
            this.$Message.success(nodesc);
        },
        warning (nodesc) {
            this.$Message.warning(nodesc);
        },
        error (nodesc) {
            this.$Message.error(nodesc);
        },
        swr (nodesc="Oops! something went wrong") {
            this.$Message.error(nodesc);
        },
        checkUserPermission(key){
            if(!this.userPermission) return true;
            let isPermitted = false;
            for(let d of this.userPermission){
                if(this.$route.name == d.name){
                    if(d[key]){
                        isPermitted = true;
                    }
                    break;
                }
            }
            return isPermitted;
        },
        TimeView(str){
            // let date =  new Date(str)
            let date = new Date(str);
            let mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            let day = ("0" + date.getDate()).slice(-2);
            let hour = ("0" + date.getHours()).slice(-2);
            let min = ("0" + date.getMinutes()).slice(-2);
            let time = date.getFullYear() + '-' + mnth + '-' + day + ' ' + hour + ':' + min;
            return time
        },
        apiCatch(res){
            if(res.status===401){
                this.warning(res.data.msg)
            }else if(res.status==422){
                for(let i in res.data.errors){
                    this.error(res.data.errors[i][0])
                }
            }
            else{
                this.swr()
            }
        }
    },
            
    computed:{
        ...mapGetters({
            'userPermission':'getUserPermission'
        }),

        isReadPermitted(){
            return this.checkUserPermission('read');
        },
        isWritePermitted(){
            return this.checkUserPermission('write');
        },
        isUpdatePermitted(){
            return this.checkUserPermission('update');
        },
        isDeletePermitted(){
            return this.checkUserPermission('delete');
        },
    }

}