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
    <style>
        .toggle__dot {
            top: -.25rem;
            left: -.25rem;
            transition: all 0.3s ease-in-out;
        }

        input:checked ~ .toggle__dot {
            transform: translateX(100%);
            background-color: #48bb78;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0; 
        }

        #vdoview {
            position: relative;
        }
    </style>
</head>

<body>

    <div id='app' class="flex flex-col w-full">
        <header class="shadow-md">
            <nav class="flex items-center justify-between flex-wrap bg-gray-100 p-2">
                <div class="flex items-center flex-shrink-0 text-black mr-6">
                    <img class="imglogo"
                        src="https://www.eventinsight.co/testweb/eventpassinsight/web/img/Header%2099.5x40%20px%20Long-01.png" style="width:250px;">
                    <span class="font-semibold text-xl tracking-tight"></span>
                </div>
                <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                    <div class="text-sm flex">
                        <div class="flex flex-no-wrap mr-2" style="min-width:300px;">
                            <label class="whitespace-no-wrap">เลือก Access: &nbsp;&nbsp;</label>
                            <select class="w-full border"  name="access" id="access" v-model="accessdoor">
                                    <option value="ประตู่ 1 (IN)">ประตู่ 1 (IN)</option>
                                    <option value="ประตู่ 1 (OUT)">ประตู่ 1 (OUT)</option>
                                    <option value="ประตู่ 2 (IN)">ประตู่ 2 (IN)</option>
                                    <option value="ประตู่ 2 (OUT)">ประตู่ 2 (OUT)</option>
                            </select>
                        </div>
                        <div class="flex flex-no-wrap mr-3" style="min-width:300px;">
                            <label class="whitespace-no-wrap">เลือก เวลา: &nbsp;&nbsp;</label>
                            <select class="w-full border"  name="access" id="access" v-model="inttime" @change="changeinittime" >
                                    <option value="100">100 (1/10 วินาที)</option>
                                    <option value="300">300 (3/10 วินาที)</option>
                                    <option value="500">500 (ครึ่งวินาที)</option>
                                    <option value="1000">1000 (1วินาที)</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-center w-full mr-5">
                            <label for="toogleA"
                                class="flex items-center cursor-pointer" >
                                <div class="relative">
                                <input id="toogleA" type="checkbox" class="hidden" v-model="checked" @change="changeinittime" />
                                <div class="toggle__line w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                                <div class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0"></div>
                                </div>
                                <div class="ml-3 text-gray-700 font-medium">
                                {{checked ? 'เปิด' : 'ปิด'}}
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="mx-4 my-4 flex " style="height:100%;">
                <div class="mx-2 w-9/12 bg-green-100 overflow-y-scroll" :style=" 'max-height:' + (+window.height-150) + 'px;height:'+(+window.height-150)+'px;'">
                    <div v-for="(member,idx) in resultmembers" :key="idx">--{{member.count}}-----{{member.t}}------------{{member.name}}---{{member.data.gender}}----</div>
                </div>
                <div class="mx-2 w-3/12 h-full bg-blue-200">
                    <div class="my-1 mx-1 flex flex-col">
                        <div class="w-full" id="vdoview" ref="vdoview">
                            <video autoplay="true" id="video" class="mb-1 pr-1" width="320" height="320"></video>
                        </div>
                    </div>
                </div>
                <div id="results">Your captured image will appear here...</div>
        </div>
        
        <footer class="absolute border items-center flex justify-between w-full" 
            style="height:62px;bottom:1px;background-color: #e9eceb;
            ">
          <div class="mx-4">
                <img src="https://www.eventpassinsight.co/web/web/img/Header%2099.5x40%20px%20Long-01.png"
                    style="width:200px;">
          </div>
          <div class="mx-4">
              <div class="whitespace-no-wrap">
                Width: {{ window.width }},
                Height: {{ window.height }}                        
            </div>
          </div>
          <div class="mx-4">
              <label>Copyright© by eventpassinsight.co</label>
          </div>
        </footer>
    </div>

    <script src='https://unpkg.com/axios/dist/axios.min.js'></script>
    <script src='/views/js/webcam.min.js'></script>
    <!-- <script src='https://unpkg.com/simple-web-worker@1.2.0/dist/sww.min.js'></script> -->
    <script type='module'>
    import Vue from 'https://unpkg.com/vue@2.6.10/dist/vue.esm.browser.min.js';
    // Vue.prototype.$worker = WorkerWrapper;
    import VueRouter from 'https://unpkg.com/vue-router@3.1.3/dist/vue-router.esm.browser.min.js';
    let baseurl = 'http://localhost';
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
        myWorker:'',
        count:1,
        accessdoor:1,
        inttime:1000,
        setinitime:1000,
        interver:'',
        checked:false,
        video:'',
        canvas:'',
        ctx:'',
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
        window: {
            width: 0,
            height: 0
        },
        extractfaces:[],
        resultmembers:[],
        detection:'',
        members:[],
    }},
    el:'#app',
    methods:{
        snapshotpic(){
            console.log('----snapshotpic----');
            // this.canvas = document.createElement('canvas');
            // this.canvas.width = this.video.videoWidth;
            // this.canvas.height = this.video.videoHeight;
            // this.h = this.video.videoHeight;
            // this.w = this.video.videoWidth;
            // var ctx = this.canvas.getContext('2d');
            this.ctx.drawImage(this.video, 0, 0, this.video.videoWidth, this.video.videoHeight);
            var dataURI = this.canvas.toDataURL('image/jpeg'); // can also use 'image/png'
            this.dataURI = dataURI;
            console.log('w-h:-->',this.w,':',this.h);
            this.logimg(this.dataURI);
            this.train();
        },
        initCanvas(e) {
            this.canvas.width = this.video.videoWidth;
            this.canvas.height = this.video.videoHeight;
        },
        chkpic(){
            console.log('---chkpic----');
            this.callapi(this.detection);
        },
        postdata(member){
            console.log('--postdata---',member);
            // let name = member.name.split(' ');
            // this.user.firstname = name[0];
            // this.user.lastname =  name[1];
            // this.user.address =   'member.address';
            // this.resultmembers = [];
            // this.extractfaces = [];
            // this.dataURI = null;
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
            setTimeout(()=>{ 
                this.h = this.video.videoHeight;
                this.w = this.video.videoWidth;
                this.canvas = document.createElement('canvas');
                this.canvas.width = 320;
                this.canvas.height = 320;
                this.$refs.vdoview.append(this.canvas);
                // this.canvas.width = this.video.videoWidth;
                // this.canvas.height = this.video.videoHeight;
                this.h = this.video.videoHeight;
                this.w = this.video.videoWidth;
                this.ctx = this.canvas.getContext('2d');

                Webcam.set({
                    width: 320,
                    height: 320,
                    // width: this.w,
                    // height: this.h,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#video');
                this.changeinittime();
            }, 1000);   
        },
        loadmodels(){
            Promise.all([

                //  set 1
                // faceapi.nets.faceRecognitionNet.loadFromUri('/views/models'),
                // faceapi.nets.faceLandmark68Net.loadFromUri('/views/models'),
                // faceapi.nets.ageGenderNet.loadFromUri('/views/models'),
                // faceapi.nets.ssdMobilenetv1.loadFromUri('/views/models')

                //set 2
                // faceapi.nets.tinyFaceDetector.loadFromUri('/views/models'),
                // faceapi.nets.faceLandmark68Net.loadFromUri('/views/models'),
                // faceapi.nets.faceRecognitionNet.loadFromUri('/views/models'),
                // // faceapi.nets.faceExpressionNet.loadFromUri('/views/models'
                // faceapi.nets.ageGenderNet.loadFromUri('/views/models'),
                // faceapi.nets.ssdMobilenetv1.loadFromUri('/views/models')

                //set 3
                // faceapi.nets.tinyFaceDetector.loadFromUri('/views/models'),
                // faceapi.nets.faceLandmark68Net.loadFromUri('/views/models'),
                // faceapi.nets.faceRecognitionNet.loadFromUri('/views/models'),
                // faceapi.nets.faceExpressionNet.loadFromUri('/views/models'),
                // faceapi.nets.ageGenderNet.loadFromUri('/views/models')

                faceapi.loadTinyFaceDetectorModel('/views/models'),
                faceapi.loadFaceLandmarkTinyModel('/views/models'),
                faceapi.loadFaceRecognitionModel('/views/models'),
                faceapi.nets.ageGenderNet.loadFromUri('/views/models')

            ]).then(this.vdoplay)
        },
        async train(){
            const detections = await faceapi.detectAllFaces(this.video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks() // ตรวจโครงหน้า 
                .withFaceExpressions() // หาหน้าตาว่าเป็นแบบไหน สนุก เศร้า ธรรมชาติ ร้องให้ อื่น ๆ 
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
            }).catch(err=>console.error(err))
        },
        addmember(){
            if(this.detection){
                let member = { gender: this.detection.gender ,queryFace: this.detection.descriptor ,user: this.user,imgurl: this.detection.facedata };
                console.log('callapi add member---->',member);
                let url = baseurl+'/api/addmember';
                axios.post(url,member).then(data=>{
                    console.log('-----api--retuen----',data);
                }).catch(err=>console.error(err))
            }
        },
        testface(data){
            let url = baseurl+'/api/testface';
            axios.post(url,{ gender:data.gender,queryFace:data.descriptor }).then(rs=>{
                console.log('-----api--retuen----',rs);
                if(rs.data.length > 0 ){
                    this.updatedata(rs.data[0]);
                    this.updatemember(rs.data[0]);
                    data.member = rs.data[0];
                    this.drawbox(data);
                }
            }).catch(err=>console.error(err))

        },
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
        changeinittime(){
            console.log('-----changeinittime-----');
            clearInterval(this.interver);
            this.setinitime = this.inttime;
            this.interver = setInterval(() => {
                if(this.checked){
                    console.log('---setInterval---',this.setinitime);
                    // this.deteceface();
                    this.detecefaceA();
                    // this.detecefaceB();
                } else{
                     this.canvas.getContext('2d').clearRect(0, 0, this.canvas.width, this.canvas.height);
                }
            }, this.setinitime);
        },
        detecefaceB(){
            Webcam.snap((data_uri) =>{
                    this.logimg(data_uri);
                    let url = 'http://127.0.0.1';
                    axios.defaults.baseURL = 'http://127.0.0.1';
                    axios.defaults.headers.post['Content-Type'] ='application/json;charset=utf-8';
                    axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';
                    axios.post(url,{imageDate:data_uri}).then(member=>{
                        console.log('member-->',member);
                        this.updatedata(member);
                    }).catch(console.error);
            });
        },
        detecefaceA(){
                Webcam.snap((data_uri) =>{
                    this.logimg(data_uri);
                    window.data_uri = data_uri;
                    let img = new Image();
                    img.src = data_uri;
                     let inputSize = 512;
                     let scoreThreshold = 0.5;
                    const OPTION = new faceapi.TinyFaceDetectorOptions({
                        inputSize,
                        scoreThreshold
                    });
                    const useTinyModel = true; 
                    this.canvas.getContext('2d').clearRect(0, 0, this.canvas.width, this.canvas.height);
                    // faceapi.detectAllFaces(img, new faceapi.TinyFaceDetectorOptions()) // old
                    faceapi.detectAllFaces(img,OPTION)
                        .withFaceLandmarks(useTinyModel)
                        .withAgeAndGender()
                        .withFaceDescriptors().then(detections=>{
                            console.log('-------Interval----'+ this.inttime +'-----', detections); 
                            const displaySize = { width: video.width, height: video.height }
                            const resizedDetections = faceapi.resizeResults(detections,displaySize);
                            detections.map(member=>{
                                // this.updatedata(Math.random()); //test with Math.random();
                                // this.updatedata(member); //test with Math.random();
                                this.testface(member);
                            });
                        });
                });
        },
        deteceface(){
            this.updatedata(Math.random());
            // // const detections = await 
            faceapi.detectAllFaces(this.video, new faceapi.TinyFaceDetectorOptions()) //old
            .withFaceLandmarks()
            // .withFaceExpressions()
            .withAgeAndGender()
            .withFaceDescriptors().then(detections=>{
                console.log('-------Interval----'+ this.inttime +'-----', detections); 
                detections.map(member=>{
                    this.updatedata(member);
                })
            });
        },
        updatedata(data){
            if(this.resultmembers.length > 35 ){
                this.resultmembers.pop();
            } 
            let obj = {
                count: this.count,
                data:data,
                t: new Date().valueOf(),
                name: data.name ? data.name : 'Unkonwn'
            }
            this.resultmembers.unshift(obj);
            this.count++;
        },
        updatemember(member){
            if(member.name){
                let m = this.members.find(m=>m.name==member.name);
                if(m){
                    m.updatetime();
                    console.log('---members---',this.members);
                } else {
                    member.access = this.accessdoor;
                    let a = new Member(member);
                    this.members.push(a)
                }
            } else {
                console.log('-----unknown---name---');
            }


        },
        drawbox(detection){
            console.log('----drawbox----');
            // let  ctx = this.canvas.getContext('2d');
            // this.ctx.drawImage(this.video, 0, 0, this.video.videoWidth, this.video.videoHeight);
            // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
            // faceapi.draw.drawDetections(this.canvas,resizedDetections);
            // faceapi.draw.drawFaceLandmarks(this.canvas, resizedDetections)
            let name = detection.member.name ? detection.member.name :'ไม่ทราบ';
            let gender = detection.gender ? detection.gender : 'xy';
            const box = detection.detection.box;
            const drawBox = new faceapi.draw.DrawBox(box, { label: name + '---' + gender });
            drawBox.draw(this.canvas);
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
    created       () { /* console.log('created'); */ 
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
    },
    beforeMount   () { /* console.log('beforeMount'); */ },
    mounted       () { /* console.log('mounted'); */    
        this.video = document.querySelector("#video");
        window.video = this.video;
        this.loadmodels();
        console.log('----vue is mounted----');
        window.ars = this.members;
    },
    beforeUpdate  () { /* console.log('beforeUpdate'); */ },
    updated       () { /* console.log('updated'); */ },
    beforeDestroy () { /* console.log('beforeDestroy'); */ },
    destroyed     () { /* console.log('destroyed'); */ 
        window.removeEventListener('resize', this.handleResize)
    },
    });

    class Member {

        constructor(member) {
            this.created_at = new Date().valueOf();
            this.updated_at = this.created_at;
            this.member = member;
            this.name = member.name;
            console.log('---test---',this.created_at);
            this.interval = setInterval(this.chktime.bind(this), 5000);
        }

        chktime() {
            let a = new Date().valueOf();
            console.log("---test--interval----", (+a - this.created_at));
            if( (+a - this.updated_at)>15000) {
                this.savemember();
            }
        }
        updatetime(){
            this.updated_at = new Date().valueOf();
        }

        savemember(){
            this.member.created_at = this.created_at;
            this.member.updated_at = this.updated_at;
            let url = "http://localhost/api/addmemassets";
            axios.post(url,JSON.stringify(this.member)).then(rs=>{
                console.log('---rs---add addmemassets---',rs);
                this.destroy();
            }).catch(console.error);    
        }

        destroy() {
            clearInterval(this.interval);
            let index = ars.indexOf(this);
            ars.splice(index,1);
            console.log('----end----');
        }
    }

</script>
</body>

</html>