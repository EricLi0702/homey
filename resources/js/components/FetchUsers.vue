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
                console.log(res)
            })
            .catch(err=>{
                console.log(err)
            })
    }
}
</script>