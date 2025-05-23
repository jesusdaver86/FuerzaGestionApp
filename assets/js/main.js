let $ = (s) => document.querySelector(s);
let checkBox = $("#Torch");
let container = $(".container");
let errorWindow = $(".warningWindow");


// Set up the height of the page
window.onload = function(){
    container.style.cssText = `height:${window.innerHeight}px`;
}

// Main work 

let currentCheckBoxStatus, track, image, allStream;

let turnOnOff = () =>{
    currentCheckBoxStatus = checkBox.checked;
    if(currentCheckBoxStatus == true){
        window.navigator.mediaDevices.getUserMedia({video:{facingMode : {exact : "environment"}}})
        .then((stream)=>{
            track = stream.getVideoTracks()[0];
            image = new ImageCapture(track);
            return image.getPhotoCapabilities()
        })
        .then((value)=>{
            if (value.fillLightMode.length > 0) {
                track.applyConstraints({
                    advanced : [{torch : true}]
                })
            };
        })
        .catch((err)=>{
            // console.log(err);
            errorWindow.classList.add("warningShow");
        })
    }else{
        track.stop();
    }
    
}

checkBox.addEventListener("change", turnOnOff);

