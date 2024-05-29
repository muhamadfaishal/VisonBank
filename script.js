let model, webcam, labelContainer, maxPredictions;
let capturedImage, sumDetected;

// Load the image model and setup the webcam
async function init() {
    const URL = "https://teachablemachine.withgoogle.com/models/PjMy2R9Gc/";
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";

    // Load the model and metadata
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    // Setup the webcam
    const flip = true;
    webcam = new tmImage.Webcam(600, 450, flip); // Set the width and height to match the placeholder
    await webcam.setup(); // request access to the webcam
    await webcam.play();
    window.requestAnimationFrame(loop);

    // Append the webcam canvas to the placeholder div
    document.getElementById("webcam-placeholder").appendChild(webcam.canvas);
    document.getElementById("sum-display").style.display = "block";

    document.getElementById("start").style.display = "none";
    document.getElementById("crop").style.display = "block";
}

async function loop() {
    webcam.update(); // update the webcam frame
    await predict();
    window.requestAnimationFrame(loop);
}

// Run the webcam image through the image model
async function predict() {
    const prediction = await model.predict(webcam.canvas);

    let sum = 0;
    for (let i = 0; i < maxPredictions; i++) {
        if (prediction[i].className === "1Ribu" && prediction[i].probability > 0.8) {
            sum += 1000;
        } else if (prediction[i].className === "2Ribu" && prediction[i].probability > 0.7) {
            sum += 2000;
        } else if (prediction[i].className === "5Ribu" && prediction[i].probability > 0.7) {
            sum += 5000;
        } else if (prediction[i].className === "10Ribu" && prediction[i].probability > 0.7) {
            sum += 10000;
        } else if (prediction[i].className === "20Ribu" && prediction[i].probability > 0.7) {
            sum += 20000;
        } else if (prediction[i].className === "50Ribu" && prediction[i].probability > 0.7) {
            sum += 50000;
        } else if (prediction[i].className === "100Ribu" && prediction[i].probability > 0.7) {
            sum += 100000;
        }
    }
    document.getElementById("sum").innerText = sum;
}

function capture() {
    const canvas = document.createElement("canvas");
    canvas.width = webcam.canvas.width;
    canvas.height = webcam.canvas.height;
    const context = canvas.getContext("2d");
    context.drawImage(webcam.canvas, 0, 0);

    capturedImage = canvas.toDataURL("image/png");
    document.getElementById("captured-image").src = capturedImage;
    document.getElementById("captured-image-container").style.display = "block";

    webcam.stop();
    document.getElementById("webcam-placeholder").style.display = "none";

    sumDetected = document.getElementById("sum").innerText;

    document.getElementById("crop").style.display = "none";
    document.getElementById("start-again").style.display = "block";
    document.getElementById("save").style.display = "block";
}

function saveData() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert(xhr.responseText);  // Alert the server response
                if (xhr.responseText.includes("successfully")) {
                    // Reload to update balance
                    window.location.reload();
                }
            } else {
                alert("Failed to save data: " + xhr.status);
            }
        }
    };
    const data = "nominal=" + sumDetected + "&timestamp=" + new Date().toISOString();
    xhr.send(data);
}

function startAgain() {
    document.getElementById("start-again").style.display = "none";
    document.getElementById("save").style.display = "none";
    document.getElementById("captured-image-container").style.display = "none";
    document.getElementById("webcam-placeholder").style.display = "block";

    init();
}
