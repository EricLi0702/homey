<template>
    <div>
        <Button type="info" size="small" @click="addRole">Add</Button>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Crated at</th>
                <th>Action</th>
            </tr>
            <template v-if="roleLists && roleLists.length > 0">
                <tr v-for="(role,i) in roleLists" :key="i">
                    <td>{{role.id}}</td>
                    <td>{{role.roleName}}</td>
                    <td>{{role.permission}}</td>
                    <td>{{TimeView(role.created_at)}}</td>
                    <td class="d-flex">
                        <Button type="info" size="small" @click="showEditModal(role,i)">Edit</Button>
                        <Button type="error" size="small" @click="showDeletingModal(role,i)" :loading="role.isDeleting">Delete</Button>
                    </td>
                </tr>
            </template>
        </table>
    </div>
</template>

<script>
import {mapAction} from 'vuex'
export default {
    mounted(){
        this.$store.dispatch('user/fetchUserRole')
    }
}
</script>