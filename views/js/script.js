const video = document.getElementById('video')
const v = 0;
let matcher = '';
let facedatas = '';
let faces = [];

let bigGenerator = function* () {
  let N = facedatas.length;
  for (let i = 0; i < N; i++) {
    yield facedatas[i];
  }
}
function* fgen(arrs) {
  let N = arrs.length;
  for (let i = 0; i < N; i++) {
    yield arrs[i];
  }
}


Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/models'),
  faceapi.nets.ageGenderNet.loadFromUri('/models')
]).then(startVideo)

function getJson() {
  // axios.get('/api/faces/json').then(rs => {
  //   facedatas = rs.data;
  //   // if( typeof(rs.data) == "object"){
  //   // } else {
  //   //     console.log('-----error---data---is string-----');
  //   // }
  // }).catch(err => {
  //   console.log(err);
  // })
}
getJson();

function startVideo() {
  // navigator.mediaDevices. getUserMedia({
  //      audio: false,
  //      video: true
  //    })
  //    .then(stream => video.srcObject = stream)
  //    .catch(err => console.error(err));

  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
  )

  //   navigator.mediaDevices.enumerateDevices().then(devices => {
  //     var videoDevices = [0,0];
  //     var videoDeviceIndex = 0;
  //     devices.forEach(function(device) {
  //       console.log(device.kind + ": " + device.label +
  //         " id = " + device.deviceId);
  //       if (device.kind == "videoinput") {  
  //         videoDevices[videoDeviceIndex++] =  device.deviceId;    
  //       }
  //     });
  //     if(v===1){
  //         //var constraints =  {width: { min: 1024, ideal: 1280, max: 1920 }, height: { min: 776, ideal: 720, max: 1080 },
  //         // var constraints =  {width: { min: 1920, ideal: 1920, max: 1920 }, height: { min: 1080, ideal: 1080, max: 1080 },
  //         var constraints =  {
  //               width: { min: screen.width, ideal: screen.width, max: screen.width }, 
  //               height: { min: screen.height, ideal: screen.height, max: screen.height },
  //               deviceId: { exact: videoDevices[1]  } 
  //         };
  //     	  console.log('----constraints----',constraints,videoDevices[1]);
  //     } else {
  //         var constraints =  {
  //           width: { min: 620, ideal: 620, max: 620 },
  //           height: { min: 560, ideal: 560, max: 560 },
  //           deviceId: { exact: videoDevices[0]  } 
  //         };
  //     	  console.log('----constraints----',constraints,videoDevices[0]);
  //     }

  //   return navigator.mediaDevices.getUserMedia({ video: constraints });
  // }).then(stream =>video.srcObject=stream).catch(e => console.error(e));
}

setInterval(() => {
  console.log('----Get New Json');
  getJson();
}, 1000 * 60 * 60);  // 1000 * 60 * 60 == 1 Hr.


video.addEventListener('play', () => {
  let inttime = 400;
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  // console.log('----displaySize----', displaySize);
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks()
      .withAgeAndGender()
      .withFaceDescriptors();
    // console.log('-------Interval----'+ inttime +'-----', detections);

    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    if(detections.length > 0 ){
      await detections.map(async (detection, i) => {
        console.log('gender---->',detections[0].gender);    
        // console.log('gender---->',detections[0].descriptor);    
        // console.log('---detection---', i, detection);
          // const box = detection.detection.box;
          // const drawBox = new faceapi.draw.DrawBox(box, { label: 'unknow '+detection.gender });
          // drawBox.draw(canvas);
          if (detection.descriptor) {
              getFaces(detection, canvas);
          } else {
            const box = detection.detection.box;
            const drawBox = new faceapi.draw.DrawBox(box, { label: 'unknow'+ ' '+detection.gender });
            drawBox.draw(canvas);
          }
      })
    } 

    // const resizedDetections = faceapi.resizeResults(detections, displaySize)
    // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    // console.log('resizedDetections----->',resizedDetections);
    // faceapi.draw.drawDetections(canvas, resizedDetections)
  }, inttime)
})

function euclideanDistance(arr1, arr2) {
  var desc1 = arr1;
  var desc2 = arr2;
  let euc = Math.sqrt(desc1
    .map((val, i) => {
      return val - desc2[i];
    })
    .reduce((res, diff) => {
      return res + Math.pow(diff, 2);
    }, 0));
  return euc;
}

function computeMeanDistance(queryFace, descriptors) {
  return descriptors
    .map((d) => {
      return euclideanDistance(queryFace, new Float32Array(Object.values(d.descriptor)));
    })
    .reduce((d1, d2) => {
      return d1 + d2;
    }, 0) /
    (descriptors.length || 1);
}

async function matchDescriptor(queryFace) {
  let labels = [];
  let bigArr = bigGenerator();
  for (let face of bigArr) {
    var descriptors = face.descriptors;
    face.distance = await computeMeanDistance(queryFace, descriptors);
    if (face.distance < 0.3 && face.distance !== 0) {
      labels.push(face);
    }
  }
  return labels;
}

let getmin = (prev, curr) => prev.Cost < curr.Cost ? prev : curr;

async function getFaces(detection, canvas) {
  // console.log('-----------start---getFace----------------');
  canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
  // console.log('-----canvas width and height----', canvas.width, canvas.height);
  let queryFace = detection.descriptor;
  let gender = detection.gender;
  axios.post('/api/testface',{ queryFace, gender } ).then(rs => {
      console.log('--------------------rs---------->', rs );
      const box = detection.detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, { label: (rs.data[0].name?rs.data[0].name:'unknown') +' '+ gender });
      drawBox.draw(canvas);
  }).catch(console.log);
}