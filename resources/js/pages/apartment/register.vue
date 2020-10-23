<template>
  <div>
    <Button type="info" size="small" @click="addModal = true">Add</Button>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Crated at</th>
            <th>Action</th>
        </tr>
        <template v-if="aptLists && aptLists.length > 0">
            <tr v-for="(apt,i) in aptLists" :key="i">
                <td>{{i+1}}</td>
                <td v-if="apt.isEditing == undefined || apt.isEditing == false">{{apt.aptName}}</td>
                <td v-else-if="apt.isEditing == true"><Input v-model="apt.aptName" style="width:220px"/></td>
                <td>{{TimeView(apt.created_at)}}</td>
                <td class="d-flex">
                    <Button v-if="apt.isEditing == undefined || apt.isEditing == false" type="info" size="small" @click="editApt(apt,i)">Edit</Button>
                    <Button v-else-if="apt.isEditing == true" type="info" size="small" @click="updateApt(apt,i)" :disabled="isEditing" :loading="isEditing">Update</Button>
                    <Button type="error" size="small" @click="delApt(apt,i)">Delete</Button>
                </td>
            </tr>
        </template>
    </table>
    <Modal
        v-model="addModal"
        title="Add apt"
    >
        <Input v-model="addData.aptName" class="mb-2" placeholder="Enter something..."/>
        
        <div slot="footer">
            <Button type="default" @click="addModal=false">Close</Button>
            <Button type="primary" @click="addApt" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding': 'Add apt'}}</Button>
        </div>
    </Modal>
  </div>
</template>

<script>
import {addApt,getAptLists,updateApt,delApt} from '~/api/apartment'
export default {
  data(){
    return{
      addModal:false,
      aptLists:[],
      addData:{
        aptName:'',
      },
      isAdding:false,
      isEditing:false,

    }
  },
  mounted(){
    getAptLists()
      .then(res=>{
        console.log(res)
        this.aptLists = res.data
      })
      .catch(err=>{
        console.log(err)
      })
  },
  methods:{
    async  addApt(){
      this.isAdding = true
      await addApt(this.addData)
        .then(res=>{
          console.log(res)
          this.aptLists.unshift(res.data)
        })
        .catch(err=>{
          console.log(err)
        })
      this.isAdding = false
      this.addModal = false
      this.addData.aptName = ''
    },

    editApt(apt,index){
      this.$set(apt,'isEditing',true)
      console.log(apt)
    },
    updateApt(apt,index){
      if(apt.aptName.trim() == ''){
        return this.error('aptName is required')
      }
      this.isEditing = true
      updateApt(apt)
        .then(res=>{
          apt.isEditing = false
        })
        .catch(err=>{

        })
      this.isEditing = false
    },
    delApt(apt,index){
      delApt(apt)
        .then(res=>{
          this.aptLists.splice(index,1)
        })
        .catch(err=>{
          console.log(err)
        })
    }
  }
}
</script>

<style>

</style>