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
                console.log(res.data)
            })
            .catch(err=>{
            })
    }
}
</script>