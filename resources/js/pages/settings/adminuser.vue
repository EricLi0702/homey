<template>
    <div>

    </div>
</template>
<script>
import menuItem from '../../components/pages/basic/menuItem';
import cityListJson from '!raw-loader!./cityLaw.txt';
import Avatar from 'vue-avatar'
export default {
    components:{
        menuItem,
        Avatar,
    },
    data () {
        return {
            modalData:{
                name:'',
                phoneNumber:'',
                password:'',
                roleId:null,
                lessonId:null,
                gradeId:null,
                gender:null,
                nation : '',
                cardNum : '',
                familyAddress : {
                    province : null,
                    city : null, 
                    region : null,
                    detail : '',
                },
                residenceAddress : {
                    province : null,
                    city : null, 
                    region : null,
                    detail : '',
                },
                imgUrl : null,
            },
            addModal:false,
            isAdding:false,
            users:[],
            editModal:false,
            editData:{
                name:'',
                phoneNumber:'',
                password:'',
                roleId:null,
                lessonId:null,
                gradeId:null,
                gender:null,
                nation : '',
                cardNum : '',
                familyAddress : {
                    province : null,
                    city : null, 
                    region : null,
                    detail : '',
                },
                residenceAddress : {
                    province : null,
                    city : null, 
                    region : null,
                    detail : '',
                },
                userAvatar : null,
            },
            index:-1,
            showDeleteModal:false,
            isDeleting:false,
            deleteItem:{},
            deletingIndex:-1,
            roles:[],
            uploadModal:false,
            token:window.Laravel.csrfToken,
            uploadExcelFile:null,
            provinceListJsonArr:[],
            madeJsonFromString : [],
            willBeCityDataOfResidenceAddress : null,
            willBeCityDataOfFamilyAddress : null,
            willBeRegionDataOfResidenceAddress : null,
            willBeRegionDataOfFamilyAddress : null,
            isRegisterStudent : false,
            schoolList : [],
            gradeList : [],
            lessonList : [],
        }
    },
    async created(){
        this.provinceListJsonArr = cityListJson.split("#");
        for (let i = 0; i < this.provinceListJsonArr.length; i++) {
            let provinceObj = {
                value : 1,
                label : "",
                city : []
            }
            let province = this.provinceListJsonArr[i].split("$")[0];
            provinceObj.value = province.split("-")[0];
            provinceObj.label = province.split("-")[1];
            this.madeJsonFromString.push(provinceObj);
            let TArea = this.provinceListJsonArr[i].split("$")[1].split("|");
            for(let j = 0 ; j < TArea.length ; j++){
                let cityObj = {
                    value : 1,
                    label : "",
                    region : []
                }
                let cityArr = TArea[j].split(",");
                cityObj.value = cityArr[0].split("-")[0];
                cityObj.label = cityArr[0].split("-")[1];
                for( let k = 1 ; k < cityArr.length ; k++){
                    let regionObj = {
                        value : 1, 
                        label : "",
                    }
                    regionObj.value = cityArr[k].split("-")[0];
                    regionObj.label = cityArr[k].split("-")[1];
                    cityObj.region.push(regionObj);
                }
                this.madeJsonFromString[i].city.push(cityObj);
            }
        }
        const [res,resRole] = await Promise.all([
            this.callApi('get','/api/staff'),
            this.callApi('get','/api/role')
        ])
        if(res.status == 200){
            this.users = res.data;
        }else{
            this.swr();
        }
        if(resRole.status == 200){
            this.roles = resRole.data;
        }else{
            this.swr();
        }

        const [schoolTree,lessonList] = await Promise.all([
            this.callApi('get','/api/schoolTree'),
            this.callApi('get','/api/lesson'),
        ])
        if(schoolTree.status == 200){
            this.schoolList = schoolTree.data
            this.gradeList = this.schoolList[0].grades
        }
        if(lessonList.status == 200){
            this.lessonList = lessonList.data
        }
        
        if(this.$store.state.user.schoolId !== null){
            let schoolId = this.$store.state.user.schoolId
            for(let i = 0 ; i < this.schoolList.length ; i++){
                if(schoolId == this.schoolList[i]){
                    this.gradeList = this.schoolList[i].grades;
                }
            }
        }

    },
    methods:{
        showModal(){
            this.addModal = true;
        },

        async addAdmin(){
            //name validation
            if(this.modalData.name.trim() == ''){
                return this.error("Please enter name");
            }
            //nation validation
            if(this.modalData.nation.trim() == ''){
                return this.error("Please enter nationality");
            }
            //card number validation
            if(this.modalData.cardNum.trim() == ''){
                return this.error('Please enter identification number');
            }
            if(/^\d*$/.test(this.modalData.cardNum) == false){
                return this.error('Please enter the correct ID number');
            }
            //role id validation
            if(this.modalData.roleId == null){
                return this.error('Please enter the type of person');
            }
            //gender validation
            if(this.modalData.gender == null){
                return this.error('Please enter gender');
            }
            //phone number validation
            if(this.modalData.phoneNumber.trim() == ''){
                return this.error('Please enter your phone number');
            }
            if(/^\d*$/.test(this.modalData.phoneNumber) == false){
                return this.error('Please enter the correct phone number');
            }
            //password validation
            if(this.modalData.password.trim() == ''){
                return this.error('Please enter the password')
            }
            //check if password contain number
            if(/\d/.test(this.modalData.password) == false){
                return this.error('Password should contain numbers')
            }
            //check if password contain uppercase
            if(/[A-Z]/.test(this.modalData.password) == false){
                return this.error('Password should contain at least 1 uppercase letter')
            }
            //check if password contain special character
            if(/[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(this.modalData.password) == false){
                return this.error('Password should contain at least 1 special character')
            }
            //check if length of password is more than 8
            if(this.modalData.password.length < 8){
                return this.error('Password should contain at least 8 characters')
            }
            //family address validation
            if( this.modalData.familyAddress.province == null ||
                this.modalData.familyAddress.city == null ||
                this.modalData.familyAddress.region == null ||
                this.modalData.familyAddress.detail == ''){
                    return this.error('Please enter the household registration address');
            }
            //residence address validation
            if( this.modalData.residenceAddress.province == null ||
                this.modalData.residenceAddress.city == null ||
                this.modalData.residenceAddress.region == null ||
                this.modalData.residenceAddress.detail == ''){
                    return this.error('Please enter home address');
            }

            
            this.isAdding = true;
            const res = await this.callApi('post', '/api/addStaff',this.modalData)
            if(res.status == 201){
                this.users.push(res.data);
                this.success('The administrator user has been successfully added!');
                this.addModal = false;
                this.isAdding = false;
            }else{
                if(res.status === 422){
                    for(let i in res.data.errors){
                        this.error(res.data.errors[i][0]);
                    }
                }else{
                    this.swr()
                }
               
            }
            this.isAdding = false;
        },

    }

}