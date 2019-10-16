<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Vue2610-TailwindCss-AXIOS CDN JS </title>
    <!-- <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'> -->
    <!-- <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script> -->
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script> -->
    <!-- <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script> -->

    <link href='https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css' rel='stylesheet'>
    <script defer src="/views/js/face-api.min.js"></script>
</head>

<body>

    <div id='app'>
        <header class="shadow-md">
            <nav class="flex items-center justify-between flex-wrap bg-gray-100 p-2">
                <div class="flex items-center flex-shrink-0 text-black mr-6">
                    <img class="imglogo"
                        src="https://www.eventinsight.co/testweb/eventpassinsight/web/img/Header%2099.5x40%20px%20Long-01.png" style="width:250px;">
                    <span class="font-semibold text-xl tracking-tight"></span>
                </div>
                <div class="block lg:hidden">
                    <button
                        class="flex items-center px-3 py-2 border rounded text-black border-teal-400 hover:text-white hover:border-white">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                        </svg>
                    </button>
                </div>
                <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                    <div class="text-sm lg:flex-grow">
                        <a href="#responsive-header"
                            class="block mt-4 lg:inline-block lg:mt-0 text-black hover:text-blue mr-4">
                            Docs
                        </a>
                        <a href="#responsive-header"
                            class="block mt-4 lg:inline-block lg:mt-0 text-black hover:text-blue mr-4">
                            Examples
                        </a>
                        <a href="#responsive-header"
                            class="block mt-4 lg:inline-block lg:mt-0 text-black hover:text-blue">
                            Blog
                        </a>
                    </div>
                    <div>
                        <a href="#"
                            class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Download</a>
                    </div>
                </div>
            </nav>
        </header>
        <div class="mx-4 my-4 w-11/12 h-11/12 flex ">
            <div class="border" style="width:100%;">
                <div class="flex flex-col my-2">
                    <div class="flex mb-2">
                        <div class="px-3 ">
                            <label class="uppercase mb-2" for="grid-first-name">
                                First Name
                            </label>
                            <input v-model="user.firstname" type="text" class="border" />
                        </div>
                        <div class="px-3">
                            <label class="uppercase mb-2" for="grid-last-name">
                                Last Name
                            </label>
                            <input v-model="user.lastname" type="text" class="border" />
                        </div>
                    </div>
                    <div class="flex  mb-2">
                        <div class="w-full px-3">
                            <label class="uppercase mb-2" for="address">
                                address
                            </label>
                            <input v-model="user.address" type="text" class="border w-full" />
                        </div>
                    </div>
                    <div class="flex mb-2 px-3">
                        <button @click="addmember()" class="border w-24 bg-green-500 py-1">Register</button>
                    </div>
                </div>
            </div>
            <div class=" w-8">&nbsp;</div>
            <div class="border" style="width:400px;">
                <div class="my-1 mx-1 flex flex-col">
                    <div class="w-full" v-show="!dataURI">
                        <video autoplay="true" id="video" class="mb-1 pr-1" width="640" height="480"></video>
                        <button @click="snapshotpic" class="border w-24 bg-green-500 py-1">ถ่ายรูป</button>
                    </div>
                    <div class="w-full" v-if="dataURI">
                        <img :src="imgsrc" class="pl-1 border" id="shotimg" ref="shotimg" />
                        <div class="flex">
                            <button @click="chkpic" class="border w-24 bg-green-500 py-1">ดึงข้อมูล</button>
                            <button @click="cleardata" class="border w-24 bg-green-500 py-1">เคลียข้อมูล</button>
                        </div>
                    </div>
                </div>
                <div class="border flex mt-2" style="width:400px;">
                    <div class="bg-red-100 mr-1 cursor-pointer" style="min-width:50px;min-height:50px;width:100px;"
                        v-for="(face,idx ) in extractfaces" :key="idx" @click="callapi(face)">
                        <img class="w-full cover" :src="face.facedata" />
                    </div>
                </div>
            </div>

        </div>
        <footer class="absolute " style="height:270px;bottom:30px;width: 100%;">
            <div class="bg-gray-100 border flex overflow-x-auto" style="height:250px;">
                <div class="flex flex-col pr-1 px-2 py-2" v-for="(member,idx) in resultmembers"
                    style="min-width:200px;width:200px;" :key="idx" @click="postdata(member)">
                    <img :src="member.picbase64 ? member.picbase64 : member.picurl" />
                    <label class="text-base text-blue-500">{{member.name}} </label>
                </div>
            </div>
          <div>
                <img src="https://www.eventpassinsight.co/web/web/img/Header%2099.5x40%20px%20Long-01.png"
                    style="width:200px;"
                >
          </div>
        </footer>
    </div>

    <script src='https://unpkg.com/axios/dist/axios.min.js'></script>
    <script type='module'>
    import Vue from 'https://unpkg.com/vue@2.6.10/dist/vue.esm.browser.min.js';
    import VueRouter from 'https://unpkg.com/vue-router@3.1.3/dist/vue-router.esm.browser.min.js';
    const baseurl = 'http://localhost';
    Vue.use(VueRouter);
    let routes = [];
    const router = new VueRouter({
        mode: 'history',
        routes
    });

    import Vuex from 'https://unpkg.com/vuex@3.1.1/dist/vuex.esm.browser.min.js';
    Vue.use(Vuex);
    const store = new Vuex.Store({
        namespaced: true,
        state: {},
        mutations: {},
        actions: {},
        getters: {}
    });

    window.vm = new Vue({
    store,
    router,
    mixins:[],
    data(){ return {
        video:'',
        canvas:'',
        shotimg:'',
        dataURI:'',
        w:400,
        h:300,
        defaulturl:'http://via.placeholder.com/400x300',
        user:{
            firstname:'fname',
            lastname:'lname',
            address:'address'
        },
        extractfaces:[],
        resultmembers:[],
        detection:'',
    }},
    el:'#app',
    methods:{
        snapshotpic(){
            console.log('----snapshotpic----');
            this.canvas = document.createElement('canvas');
            this.canvas.width = this.video.videoWidth;
            this.canvas.height = this.video.videoHeight;
            this.h = this.video.videoHeight;
            this.w = this.video.videoWidth;
            var ctx = this.canvas.getContext('2d');
            ctx.drawImage(this.video, 0, 0, this.video.videoWidth, this.video.videoHeight);
            var dataURI = this.canvas.toDataURL('image/jpeg'); // can also use 'image/png'
            this.dataURI = dataURI;
            console.log('w-h:-->',w,':',h);
            this.logimg(this.dataURI);
            this.train();
        },
        chkpic(){
            console.log('---chkpic----');
            this.callapi(this.detection);
        },
        postdata(member){
            console.log('--postdata---',member);
            let name = member.name.split(' ');
            this.user.firstname = name[0];
            this.user.lastname =  name[1];
            this.user.address =   'member.address';
            this.resultmembers = [];
            this.extractfaces = [];
            this.dataURI = null;
        },
        cleardata(){
            this.dataURI = null;
            this.resultmembers = [];
            this.extractfaces = [];
            this.vdoplay();
        },
        vdoplay(){
            navigator.getUserMedia(
                { video: {} },
                stream => this.video.srcObject = stream,
                err => console.error(err)
            )
            setTimeout(function(){ 
                this.h = this.video.videoHeight;
                this.w = this.video.videoWidth;
            }, 1000);   
        },
        loadmodels(){
            Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('/views/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/views/models'),
                faceapi.nets.faceRecognitionNet.loadFromUri('/views/models'),
                faceapi.nets.faceExpressionNet.loadFromUri('/views/models'),
                faceapi.nets.ageGenderNet.loadFromUri('/views/models')
            ]).then(this.vdoplay)
        },
        async train(){
            const detections = await faceapi.detectAllFaces(this.video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks() // ตรวจโครงหน้า 
                // .withFaceExpressions() // หาหน้าตาว่าเป็นแบบไหน สนุก เศร้า ธรรมชาติ ร้องให้ อื่น ๆ 
                .withAgeAndGender() // หาอายุ
                .withFaceDescriptors(); // ต้องใช้ร่วมกับ Landmark
            console.log('detections-->',detections);
            // console.log('img-->',this.$refs.shotimg);
            const displaySize = { width: this.video.videoWidth, height: this.video.videoHeight }
            faceapi.matchDimensions(this.canvas, displaySize) 
            
            if(detections.length == 0){
                alert('จับหน้าไม่ได้');
                this.cleardata();
            } 

            if(detections.length == 1){
                    let detection = detections[0];
                    const box = detection.detection.box;
                    const regionsToExtract =   await new faceapi.Rect(box.left,box.top,box.width,box.height);
                    let faces = await faceapi.extractFaces(this.$refs.shotimg, [regionsToExtract]);
                    detection.facedata = await faces[0].toDataURL();
                    this.detection = detection;
                    console.log('--test---',detection);
                    this.callapi(detection,'call-with-length-1');
            }

            if(detections.length > 1){
                let extractfaces = await detections.map( async (detection, i) => {
                    const box = detection.detection.box;
                    const regionsToExtract =   await new faceapi.Rect(box.left,box.top,box.width,box.height);
                    let faces = await faceapi.extractFaces(this.$refs.shotimg, [regionsToExtract]);
                    if(faces.length > 0){
                        console.log('----wrok----------');
                        detection.facedata = await faces[0].toDataURL();
                        this.logimg(detection.facedata);
                    } else {
                       detection.facedata = null;
                    }
                    return detection;
                });    

                Promise.all(extractfaces).then(data=>{
                    this.extractfaces = data;
                    console.log('----faces > = 1 --------------',this.extractfaces );
                }) 
            }

        },
        logimg(data){
            console.log("%c  ", "background-image: url('"+data+"'); background-repeat: no-repeat; background-size: 100px 75px; font-size: 100px")
        },
        callapi(data,user=null){
            //-----axios-------------------
            console.log('callapi---->',data,user);
            this.detection = {};
            this.detection = data;
            let url = baseurl + '/api/testfaces';
            axios.post(url,{ gender:data.gender,queryFace:data.descriptor }).then(data=>{
                console.log('-----api--retuen----',data);
                this.resultmembers = data.data;
                if(data.data.length == 0 ){
                    alert('ไม่มีคนนี้ในระบบ');
                }
            }).catch(err=>console.error(err))
        },
        addmember(){
            if(this.detection){
                let member = { gender: this.detection.gender ,queryFace: this.detection.descriptor ,user: this.user,imgurl: this.detection.facedata };
                console.log('callapi add member---->',member);
                let url = baseurl+ '/api/addmember';
                axios.post(url,member).then(data=>{
                    console.log('-----api--retuen----',data);
                }).catch(err=>console.error(err))
            }

        }
    },
    computed:{
        imgsrc(){
            if(this.dataURI){
                return this.dataURI;
            }
            return 'http://via.placeholder.com/'+this.w+'x'+this.h;
        }
    },
    watch: {},
    components:{},
    // render : h => h(App),
    beforeCreate  () { /* console.log('beforeCreate'); */ },
    created       () { /* console.log('created'); */ },
    beforeMount   () { /* console.log('beforeMount'); */ },
    mounted       () { /* console.log('mounted'); */    
        this.video = document.querySelector("#video");
        window.video = this.video;
        this.loadmodels();
    },
    beforeUpdate  () { /* console.log('beforeUpdate'); */ },
    updated       () { /* console.log('updated'); */ },
    beforeDestroy () { /* console.log('beforeDestroy'); */ },
    destroyed     () { /* console.log('destroyed'); */ },
    });
</script>
</body>

</html>