<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagklasipika Ng Mga Sakit Sa Palayan</title>
    <!-- TensorFlow.js -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            background-image: url('src/bgg.jpg'); 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 6vw;
            color: #2c3e50;
        }
        #video, #capturedImage {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            
            
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        button {
            padding: 10px 20px;
            font-size: 4vw;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #3498db;
            color: white;
            transition: background-color 0.3s ease;
            flex: 1 1 40%;
            max-width: 200px;
        }
        button:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
        button:hover:not(:disabled) {
            background-color: #2980b9;
        }
        #result {
            width: 100%;
            max-width: 500px;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            font-size: 4vw;
            text-align: center;
        }
        .left-align {
            text-align: left;
        }
        #loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (min-width: 600px) {
            h1 {
                font-size: 36px;
            }
            button {
                font-size: 18px;
            }
            #result {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    <h1>Pagklasipika Ng Mga Sakit Sa Palayan</h1>

    <video id="video" autoplay playsinline></video>
    <img id="capturedImage" style="display:none;">
    <div id="loader"></div>

    <div class="button-container">
        <button id="startCamera">Buksan Ang Camera</button>
        <button id="capture" disabled>Kunan Ng Larawan</button>
    </div>

    <div id="result"></div>

    <canvas id="canvas" style="display:none;"></canvas>

    <script>
        // Firebase configuration (Replace with your own config)
        const firebaseConfig = {
            apiKey: "AIzaSyD4kYnLgUzzIZt1XUWL9DEQ5j-YhbE1C_0",
            authDomain: "farm-monitoring-7d029.firebaseapp.com",
            databaseURL: "https://farm-monitoring-7d029-default-rtdb.firebaseio.com",
            projectId: "farm-monitoring-7d029",
            storageBucket: "farm-monitoring-7d029.appspot.com",
            messagingSenderId: "205970011096",
            appId: "1:205970011096:web:5a0718eb27438d499af8ad"
        };
        firebase.initializeApp(firebaseConfig);
        const database = firebase.database();

        let model;
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const capturedImage = document.getElementById('capturedImage');
        const resultDiv = document.getElementById('result');
        const loader = document.getElementById('loader');
        const startCameraButton = document.getElementById('startCamera');
        const captureButton = document.getElementById('capture');

        // Load the model asynchronously with a loading indicator
        async function loadModel() {
            showLoader(true);
            try {
                model = await tf.loadLayersModel('https://teachablemachine.withgoogle.com/models/yadHGd27E/model.json');
                console.log('Model loaded successfully');
            } catch (error) {
                console.error('Error loading model:', error);
                alert('Failed to load the model. Please try again later.');
            } finally {
                showLoader(false);
            }
        }
        loadModel();

        // Show or hide loader
        function showLoader(show) {
            loader.style.display = show ? 'block' : 'none';
        }

        // Start the camera
        startCameraButton.addEventListener('click', async () => {
            resultDiv.innerHTML = "";
            capturedImage.style.display = 'none';
            video.style.display = 'block';
            captureButton.disabled = true;
            startCameraButton.disabled = true;

            const constraints = {
                video: {
                    facingMode: 'environment'
                }
            };

            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    captureButton.disabled = false;
                };
            } catch (err) {
                console.error("Error accessing the camera:", err);
                alert("Failed to access the camera. Please ensure you've granted camera permissions.");
                startCameraButton.disabled = false;
            }
        });

        // Capture image and classify
        captureButton.addEventListener('click', async () => {
            if (!video.srcObject) {
                alert("Please start the camera first.");
                return;
            }

            captureButton.disabled = true;
            showLoader(true);
            resultDiv.innerHTML = "";

            // Capture frame from video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            // Display captured image
            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            capturedImage.src = dataUrl;
            capturedImage.style.display = 'block';
            video.style.display = 'none';

            // Classify image
            await classifyImage(dataUrl);

            captureButton.disabled = false;
            showLoader(false);
        });

        // Classify the captured image
        async function classifyImage(imageSrc) {
            try {
                const img = new Image();
                img.src = imageSrc;
                await img.decode();

                const tensor = tf.browser.fromPixels(img)
                    .resizeNearestNeighbor([224, 224])
                    .toFloat()
                    .expandDims()
                    .div(255.0);

                const predictions = await model.predict(tensor).data();
                const topPrediction = Array.from(predictions)
                    .map((probability, index) => ({
                        probability,
                        className: getClassName(index)
                    }))
                    .sort((a, b) => b.probability - a.probability)[0];

                if (topPrediction.probability >= 0.9) {
                    resultDiv.innerHTML = `<strong>Detected:</strong> ${topPrediction.className} (${(topPrediction.probability * 100).toFixed(2)}%)`;
                    getDiseaseDetails(topPrediction.className);
                } else {
                    resultDiv.innerHTML = "<strong>Result:</strong> Hindi Maklasipika Ang Lawaran. ";
                }
            } catch (error) {
                console.error('Error during classification:', error);
                resultDiv.innerHTML = "<strong>Error:</strong> Failed to classify the image.";
            }
        }

        // Get class name based on index
        function getClassName(index) {
            const classNames = [
                'Bacterial Leaf Blight',
                'Leaf Streak',
                'Nitrogen Excess',
                'White Heads'
                // Add other disease names corresponding to your model indices
            ];
            return classNames[index] || 'Unknown';
        }

        // Get disease details from Firebase
        function getDiseaseDetails(diseaseName) {
            const diseaseRef = database.ref('diseases/' + diseaseName);
            diseaseRef.once('value')
                .then(snapshot => {
                    const disease = snapshot.val();
                    if (disease) {
                        if (typeof disease === 'object') {
                            // Construct the HTML for the disease details with left alignment
                            const name = disease.name;
                            const description = disease.description;
                            const remedies = disease.remedies.join('<br>');

                            resultDiv.innerHTML += `
                                <div class="left-align">
                                    <br><strong>Name:</strong> ${name}
                                    <br><strong>Description:</strong> ${description}
                                    <br><strong>Remedies:</strong> ${remedies}
                                </div>`;
                        } else {
                            resultDiv.innerHTML += `<br><strong>Disease Details:</strong> ${disease}`;
                        }
                    } else {
                        resultDiv.innerHTML += `<br><strong>Disease Details:</strong> No information available for ${diseaseName}.`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching disease details:', error);
                    resultDiv.innerHTML += `<br><strong>Error:</strong> Failed to retrieve disease details.`;
                });
        }
    </script>

</body>
</html>
