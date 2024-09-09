<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skynap</title>
    <meta name="mobile-web-app-capable" content="yes">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('src/SKYSNAP_back.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow-x: hidden;
        }
        .header {
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            position: relative;
        }
        .header img {
            max-width: 80px;
        }
        .header h1 {
            margin: 5px 0 0;
            font-size: 1.5em;
            color: #333;
        }
        .menu-icon {
            position: absolute;
            left: 15px;
            top: 15px;
            cursor: pointer;
            width: 30px;
        
        
        }
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
        .main-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }
        .main-buttons button {
            width: 80%;
            padding: 10px;
            font-size: 1.1em;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .main-buttons button:hover {
            background-color: #45a049;
        }
        .prediction-results {
            margin-top: 20px;
            
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
            justify-content: center; /* Center the image horizontally */
            align-items: center; 
            
        }
        .prediction-results img {
            max-width: 100%;
            border-radius: 10px;
            
            
        }
        .prediction-results h2 {
            margin-top: 10;
        }
        .prediction-results p {
            font-size: 1em;
            color: #333;
        }
    </style>
    <!-- Load TensorFlow.js -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.20.0/dist/tf.min.js"></script>
    <!-- Load Teachable Machine Library -->
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
</head>
<body>

    
    
    <div id="main">
    <div class="main-buttons">
                    <button onclick="openLwFly()">Drone Vision</button>
                    <button onclick="classifyImage()">I-classify ang Imahe</button>
                </div>
                <div id="webcam-container"></div>
                <div id="label-container"></div>`;
    </div>

    <script>
        


        function openLwFly() {
            // Android-specific code to open LW Fly app
            window.location.href = "intent:#Intent;action=android.intent.action.MAIN;category=android.intent.category.LAUNCHER;package=com.lwcx.lw119;end";
        }

        async function classifyImage() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = async (event) => {
                const file = event.target.files[0];
                if (file) {
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file);
                    image.onload = async () => {
                        const resultsDiv = document.createElement('div');
                        resultsDiv.className = 'prediction-results';
                        resultsDiv.innerHTML = `<img src="${image.src}" alt="Uploaded Image"><h2>Mga Prediksyon</h2>`;
                        document.getElementById("main").appendChild(resultsDiv);

                        try {
                            // Load and run the ripening stage model
                            const ripeningModelURL = "https://teachablemachine.withgoogle.com/models/7V236RqnY/model.json";
                            const ripeningMetadataURL = "https://teachablemachine.withgoogle.com/models/7V236RqnY/metadata.json";
                            const ripeningModel = await tmImage.load(ripeningModelURL, ripeningMetadataURL);
                            const ripeningPrediction = await ripeningModel.predict(image);

                            // Find the ripening prediction with the highest confidence
                            const highestRipeningPrediction = ripeningPrediction.reduce((prev, current) => 
                                (prev.probability > current.probability) ? prev : current);

                            // Display the ripening prediction
                            const ripeningPercent = (highestRipeningPrediction.probability * 100).toFixed(2);
                            let ripeningResultText = "";
                            if (highestRipeningPrediction.className === "Ripe" && ripeningPercent >= 85) {
                                ripeningResultText = `<p style="color:green;">${highestRipeningPrediction.className}: ${ripeningPercent}%</p>`;
                            } else if (highestRipeningPrediction.className === "Ripe" && ripeningPercent < 85) {
                                ripeningResultText = `<p style="color:red;">Hilaw: ${ripeningPercent}%</p>`;
                            } else {
                                ripeningResultText = `<p>${highestRipeningPrediction.className}: ${ripeningPercent}%</p>`;
                            }
                            resultsDiv.innerHTML += ripeningResultText;

                            // Load and run the rice field status model
                            const statusModelURL = "https://teachablemachine.withgoogle.com/models/rYYZnO5oA/model.json";
                            const statusMetadataURL = "https://teachablemachine.withgoogle.com/models/rYYZnO5oA/metadata.json";
                            const statusModel = await tmImage.load(statusModelURL, statusMetadataURL);
                            const statusPrediction = await statusModel.predict(image);

                            // Find the rice field status prediction with the highest confidence
                            const highestStatusPrediction = statusPrediction.reduce((prev, current) => 
                                (prev.probability > current.probability) ? prev : current);

                            // Display the highest status prediction
                            const statusPercent = (highestStatusPrediction.probability * 100).toFixed(2);
                            resultsDiv.innerHTML += `<h2>Status ng Palayan</h2><p>${highestStatusPrediction.className}: ${statusPercent}%</p>`;

                            // If the result is "Dapa," "Tuyo," or "Baha," display recommendations from Firebase
                            const recommendations = {
                                "Baha": {
                                    "name": "Flood Management",
                                    "description": "Ang pagpapamahala at paglutas ng baha sa mga palayan ay mahalaga upang mapanatili ang kalusugan ng pananim at maksimisahin ang ani. Narito ang ilang epektibong paraan para sa pagpapamahala ng baha sa mga palayan:",
                                    "remedies": [
                                        "Tamang Paghahanda ng Lupa at Disenyo ng Sakahan: Magtayo ng matibay na levees o bunds sa paligid ng mga palayan upang maiwasan ang pag-apaw ng tubig sa panahon ng matinding ulan o baha. Siguraduhing maayos ang pagtaas at pagpapantay ng lupa sa sakahan upang mapadali ang maayos na pagtulo ng tubig at maiwasan ang pagbabaha.",
                                        "Pinaayos na Sistema ng Irrigasyon: Regular na linisin at alagaan ang mga kanal ng irigasyon at mga sistema ng drainage upang mapanatili ang magandang daloy ng tubig at maiwasan ang pagbabara. Maglagay ng mga estruktura tulad ng mga pintuang kontrol ng tubig at mga dam upang mapanatili ang antas ng tubig at daloy sa loob ng mga palayan.",
                                        "Pamamahala sa Pananim at Lupa: Itanim ang mga uri ng palay na matibay sa baha o kayang magtagal sa matagal na pagbabaha nang hindi masyadong naapektuhan ang ani. Piliin ang tamang panahon ng pagtatanim ayon sa lokal na klima upang maiwasan ang panahon ng mataas na banta ng baha. Ayusin ang pag-aplay ng pataba upang mabawasan ang pagtakbo ng tubig at pagkawala ng sustansiya sa panahon ng baha.",
                                        "Paghahanda sa Emergency: Magpatupad ng mga sistema ng pagmamanman para sa pagsubaybay sa weather forecast, antas ng tubig, at kalagayan ng sakahan. Gumawa at ipatupad ng mga plano para sa emergency na kasama ang mga hakbang para sa pag-evacuate ng tubig, proteksyon sa mga pananim, at kaligtasan ng mga magsasaka sa panahon ng baha.",
                                        "Integrated Pest and Disease Management: Bantayan ang mga sakit na maaaring lumitaw pagkatapos ng baha, tulad ng mga fungal infection, at mag-apply ng tamang paggamot kung kinakailangan.",
                                        "Pakikipagtulungan sa Komunidad at Pamahalaan: Makipagtulungan sa mga kapwa magsasaka at komunidad upang pamahalaan ang antas ng tubig ng sabay-sabay at magbahagi ng mga mapagkukunan para sa pagkontrol ng baha. Humingi ng tulong mula sa mga ahensya ng pamahalaan para sa imprastraktura ng baha, subsidiya para sa mga uri ng pananim na matibay sa baha, at mga programa para sa relief sa sakuna."
                                    ]
                                },
                                "Dapa": {
                                    "name": "Lodging Management (Dapa)",
                                    "description": "Sa konteksto ng agrikultura, ang 'dapa' ay tumutukoy sa pagkakabuwal o pagkakalas ng mga halaman ng palay. Ito ay maaaring mangyari dahil sa mabigat na ulan, malakas na hangin, o dahil sa hindi magandang kalagayan ng mga halaman.",
                                    "remedies": [
                                        "Paghahanda ng Sakahan: Siguruhing maayos ang pagpapatag ng lupa at sistema ng pagdaloy ng tubig upang maiwasan ang pagbabaha, na maaaring magpahina sa mga halaman ng palay at magdulot ng pagkakabuwal.",
                                        "Pamamahala sa Pananim: Pumili ng mga uri ng palay na hindi gaanong prone sa pagkakabuwal. Iwasan ang labis na paglalagay ng pataba ng nitrogen, na maaaring magdulot ng labis na paglago ng halaman at dagdag na panganib sa pagkakabuwal.",
                                        "Tamang Pag-aani: Aanihin ang palay sa tamang pagkakataon upang mabawasan ang panganib ng pagkakabuwal habang ang mga halaman ay nagiging mabigat na dahil sa mga butil.",
                                        "Mekanikal na Suporta: Gumamit ng mga tukod o iba pang mekanikal na suporta upang itayo ang mga halaman ng palay kung sakaling magkaroon ng pagkakabuwal bago ang tamang panahon.",
                                        "Pamamahala ng Peste at Sakit: Kontrolin ang mga peste at sakit na maaaring magpahina sa mga halaman ng palay at magdulot ng pagkakabuwal."
                                    ]
                                },
                                "Tuyo ang Lupa": {
                                    "name": "Drought Management",
                                    "description": "Sa konteksto ng agrikultura, ang tagtuyot o drought ay isang malubhang suliranin sa mga palayan, lalo na sa mga lugar na umaasa sa ulan o tubig-ilog para sa irigasyon ng kanilang mga taniman. Narito ang ilang mga hakbang na maaaring gawin upang pamahalaan ang tagtuyot sa mga palayan:",
                                    "remedies": [
                                        "Paghahanda ng Lupa: Bago magkaroon ng tagtuyot, siguraduhing maayos ang paghahanda ng lupa tulad ng tamang pagpapatag at pagpapatibay ng mga taniman. Ito ay makakatulong sa pagtulong ng tubig sa lupa at pag-iwas sa pagkasira ng mga pananim.",
                                        "Pagtatanim ng Matibay na Varieties: Pumili ng mga uri ng palay na matibay sa tagtuyot o may kakayahan na magtagal ng maikling supply ng tubig. Ang mga ito ay karaniwang tinatawag na drought-resistant varieties.",
                                        "Pagtitipid ng Tubig: Itaguyod ang mga pamamaraan ng pagsisiguro ng tubig tulad ng teknolohiya ng patak-patak o drip irrigation. Ang mga ito ay makakatulong na tiyakin ang tamang paggamit at distribusyon ng tubig sa palayan.",
                                        "Mga Teknikal na Pamamaraan: Subukan ang mga modernong teknik tulad ng mulching o paglalagay ng plastic sa lupa upang maiwasan ang pag-evaporate ng tubig mula sa lupa. Paggamit ng mga cover crop na may kakayahan na magbigay ng shade at panatilihin ang tamang halumigmig sa lupa.",
                                        "Monitoring at Early Warning Systems: Magpatupad ng mga sistema ng pagmamanman para sa weather forecast at kondisyon ng lupa. Ito ay makakatulong sa maagang pagtukoy at pagtugon sa mga problema na dulot ng tagtuyot.",
                                        "Pagpaplano sa Pag-ani: Planuhin ang pag-ani ng palay sa tamang panahon upang mabawasan ang epekto ng tagtuyot sa ani."
                                    ]
                                }
                            };

                            if (["Dapa", "Tuyo ang Lupa", "Baha"].includes(highestStatusPrediction.className)) {
                                const rec = recommendations[highestStatusPrediction.className];
                                resultsDiv.innerHTML += `
                                    <h2>Rekomendasyon: ${rec.name}</h2>
                                    <p>${rec.description}</p>
                                    <ul>${rec.remedies.map(remedy => `<li>${remedy}</li>`).join('')}</ul>
                                `;
                            }

                            // Add "Muling Magklasipika" button
                            const reclassifyBtn = document.createElement('button');
                            reclassifyBtn.textContent = "Muling Magklasipika";
                            reclassifyBtn.style.marginTop = "20px";
                            reclassifyBtn.onclick = () => {
                                document.getElementById("main").removeChild(resultsDiv);
                                classifyImage();
                            };
                            resultsDiv.appendChild(reclassifyBtn);

                        } catch (error) {
                            console.error('Error during prediction:', error);
                            resultsDiv.innerHTML += `<p style="color:red;">Error: ${error.message}</p>`;
                        }
                    };
                }
            };
            input.click();
        }
    </script>

</body>
</html>
