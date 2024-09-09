<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aklatan Ng Peste At Mga Sakit</title>
    <style>
        body {
            background-image: url('src/Agri.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin: 20px 0;
            font-size: 2rem;
        }

        .container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    padding: 20px;
    max-width: 100%;
    box-sizing: border-box;
}

.item {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.2); /* Optional: Adds a semi-transparent background to the item */
    border-radius: 10px;
    padding: 10px;
}

.item img {
    width: 100%;
    height: 150px; /* Fixed height to ensure all images are the same height */
    object-fit: cover; /* Ensures the image covers the container without stretching */
    border: 2px solid #fff;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.item img:hover {
    transform: scale(1.05);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
}

.item p {
    margin-top: 10px;
    color: #fff;
    font-weight: bold;
}

/* Mobile view adjustments */
@media (max-width: 600px) {
    .container {
        grid-template-columns: repeat(2, 1fr); /* Two columns on mobile */
        padding: 10px;
    }

    .item img {
        height: 100px; /* Reduce image height for better fit on smaller screens */
    }
}

    </style>
</head>
<body>
    <h1>Aklatan Ng Mga Sakit At Peste Sa Palayan</h1>
    <div class="container">
        <!-- Bacterial Leaf Blight -->
        <div class="item">
            <a href="https://www.pinoyrice.com/keycheck7-pest-management-tagalog/pamamahala-ng-bacterial-blight/">
                <img src="src/bacterial_leaf_blight_image.jpg" alt="Bacterial Leaf Blight">
            </a>
            <p>Bacterial Leaf Blight</p>
        </div>

        <!-- Blue Beetle -->
        <div class="item">
            <a href="https://www.pinoyrice.com/keycheck7-pest-management-tagalog/stem-borer-o-aksip-sa-palayan/">
                <img src="src/blue_beetle_image.jpg" alt="Blue Beetle">
            </a>
            <p>Blue Beetle</p>
        </div>

        <!-- Golden Apple Snail -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=Kuhol">
                <img src="src/golden_apple_snail_image.jpg" alt="Golden Apple Snail">
            </a>
            <p>Golden Apple Snail</p>
        </div>

        <!-- Golden Apple Snail Egg -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=Kuhol">
                <img src="src/golden_apple_snail_egg_image.jpg" alt="Golden Apple Snail Egg">
            </a>
            <p>Golden Apple Snail Egg</p>
        </div>

        <!-- Green Leafhopper -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=GLH">
                <img src="src/green_leafhopper_image.jpg" alt="Green Leafhopper">
            </a>
            <p>Green Leafhopper</p>
        </div>

        <!-- Grasshopper -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=tipaklong">
                <img src="src/grasshopper_image.jpg" alt="Grasshopper">
            </a>
            <p>Grasshopper</p>
        </div>

        <!-- Rice Hispa -->
        <div class="item">
            <a href="https://kisanvedika.bighaat.com/crop/the-fight-against-paddy-hispa-best-practices-for-management/">
                <img src="src/rice_hispa_image.jpg" alt="Rice Hispa">
            </a>
            <p>Rice Hispa</p>
        </div>

        <!-- Maya -->
        <div class="item">
            <a href="https://www.bing.com/search?q=mayapest+rice&qs=n&form=QBRE&sp=-1&lq=0&pq=mayapest+rice&sc=9-13&sk=&cvid=B310453125CB4C62882EA1852A2A61D6&ghsh=0&ghacc=0&ghpl=">
                <img src="src/maya_image.jpg" alt="Maya">
            </a>
            <p>Maya</p>
        </div>

        <!-- Munia -->
        <div class="item">
            <a href="https://www.bing.com/search?q=munia+pest+tagalog&qs=NWB&pq=munia+pest+ta&sk=NW_QB1&sc=8-13&cvid=04ACDD98BF8B499BAB9E19EFFEA3204D&FORM=QBRE&sp=2&ghc=1&lq=0">
                <img src="src/munia_image.jpg" alt="Munia">
            </a>
            <p>Munia</p>
        </div>

        <!-- Rice Black Bug -->
        <div class="item">
            <a href="https://www.pinoyrice.com/keycheck7-pest-management-tagalog/rice-black-bug-rbb-o-itim-na-atangya/">
                <img src="src/rice_black_bug_image.jpg" alt="Rice Black Bug">
            </a>
            <p>Rice Black Bug</p>
        </div>

        <!-- Rice Blast -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=rice+blast">
                <img src="src/rice_blast_image.jpg" alt="Rice Blast">
            </a>
            <p>Rice Blast</p>
        </div>

        <!-- Rice Bugs -->
        <div class="item">
            <a href="https://www.pinoyrice.com/keycheck7-pest-management-tagalog/pamamahala-ng-rice-bug-o-atangya/">
                <img src="src/rice_bugs_image.jpg" alt="Rice Bugs">
            </a>
            <p>Rice Bugs</p>
        </div>

        <!-- Leaf Streak -->
        <div class="item">
            <a href="https://www.pinoyrice.com/?s=leaf+streak">
                <img src="src/leaf_streak_image.jpg" alt="Leaf Streak">
            </a>
            <p>Leaf Streak</p>
        </div>

        <!-- Nitrogen Excess -->
        <div class="item">
            <a href="https://www.bing.com/search?q=nitrogen+deficiency+in+rice&qs=SC&pq=nitrogen+defeciency+in+re&sc=10-25&cvid=171858D0C79E4617B578784AEBCDB32E&FORM=QBRE&sp=1&ghc=1&lq=0">
                <img src="src/nitrogen_excess_image.jpg" alt="Nitrogen Excess">
            </a>
            <p>Nitrogen Excess</p>
        </div>

        <!-- White Heads -->
        <div class="item">
            <a href="https://www.bing.com/search?q=whiteheads+in+rice&qs=SC&pq=white+headfs+in+ri&sc=4-18&cvid=A6CEEC80EAEA44FBBD9EC2CC64AEFFE0&FORM=QBRE&sp=1&ghc=1&lq=0">
                <img src="src/white_heads_image.jpg" alt="White Heads">
            </a>
            <p>White Heads</p>
        </div>
    </div>
</body>
</html>
