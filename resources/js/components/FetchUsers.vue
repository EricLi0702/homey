<template>
    <div>
        Fetching Users...
    </div>
</template>
<script>
import {fetchUsers} from '~/api/index'
export default {
    mounted(){
        fetchUsers()
            .then(res=>{
                
            })
            .catch(err=>{
            })
    }
}
</script>