<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Retrieve user info
$username = $_SESSION['username'];

// Handle logout
if (isset($_GET['logout'])) {
    // Regenerate session ID to prevent session fixation attacks
    session_regenerate_id(true);
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: index.php");
    exit();
}

// Restrict access to users.php and button.php
$currentFile = basename($_SERVER['PHP_SELF']);
if (($currentFile == 'users.php' || $currentFile == 'button.php') && !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Your Own boards</title>
    <!-- <link rel="stylesheet" href="nav.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="./header.css">

    <script src="../js/nav.js" defer></script>
    <script src="js/sidebar.js" defer></script>
    <script src="js/board.js" defer></script>
    <script src="js/drop.js" defer></script>
    <script src="js/icon_data.js" defer></script>
    <script src="js/component_data.js" defer></script>
    <script src="js/svg_helper.js"></script>
    <!-- <script src="js/auto_logout.js"></script> -->
    <script src="js/svg_generator.js"></script>
    <script src="js/frame_data.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <!-- FontAwosomeIconLinkBelow-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- GoogleFontsLink -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- BootStrap -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>

<body>
    <!--Header Bar Start-->
    <header>
        <div class="logo_img">
            <img src="logo.png" alt="G6 Logo">
        </div>
        <div class="logo">
            G6 Superhomes
        </div>
        <nav>
            <span class="username-at-header">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <!--add link below-->
            <a href="http://localhost/internship/view_product/" class="cart-btn" id="cartBtn">
                <i class="fa-solid fa-shopping-cart"></i> View Cart
            </a>


            <a href="?logout=true style=" color: red; class="logout-btn">
                Logout<i class="fa-solid fa-sign-out-alt" style="color: red; margin-left: 7px;"></i>
            </a>
        </nav>
    </header>
    <!--Header Bar End-->

    <!-- <div class="mobile-vertical-msg">Please turn your device to Landscape mode</div>
        <nav>
        <a href="../" class="logo">
            <img src="../img/logo.png" alt="G6 Logo">
            <h1>G6 Superhomes</h1>
        </a>
        <div class="menu-btn" onclick="toggle_menu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="navigation">
            <ul>
                <li class="page-links"><a href="../">Home</a></li>
                <li class="page-links"><a href="../about-us">About Us</a></li>
                <li class="page-links">
                    <input type="checkbox" name="show-products" id="show-products" class="show-products">
                    <label for="show-products">
                        <a>Products</a>
                    </label>
                    <div class="preview product-preview">
                        <a class="product" href="../superswitch">
                            <img src="../img/superswitch.png" alt="">
                            <p>Superswitch</p>
                        </a>
                        <a class="product" href="../megaswitch">
                            <img src="../img/megaswitch.png" alt="">
                            <p>Megaswitch</p>
                        </a>
                    </div>
                </li>
                <li class="page-links"><a href="../portals">Portals</a></li> 
                <li class="page-links">
                    <input type="checkbox" name="show-portals" id="show-portals" class="show-portals">
                    <label for="show-portals">
                        <a>Portals</a>
                    </label>
                    <div class="preview portal-preview">
                        <a class="portal" href="../../operations">
                            <img src="../img/operations.svg" alt="">
                            <p>Operations</p>
                        </a>
                        <a class="portal" href="../myob">
                            <img src="../img/myob.svg" alt="">
                            <p>Make your own board</p>
                        </a>
                        <a class="portal" href="../admin-panel">
                            <img src="../img/blog-admin.svg" alt="">
                            <p>Blog admin panel</p>
                        </a>
                    </div>
                </li>
                <li class="page-links"><a href="../opportunities">Opportunities</a></li>
                <li class="page-links"><a href="../blogs">Blogs</a></li>
                <li class="page-links"><a href="../support">Support</a></li>

                <li class="search-li">
                    <form action="../blogs/search.php" method="GET" id="search_form">
                        <input type="text" name="search" id="search" placeholder="Search Blogs" autocomplete="off">
                    </form>
                    <img src="../img/search.png" id="desktop-search-btn" alt="Search btn" onclick="open_search()">
                    <img src="../img/search.png" id="mobile-search-btn" alt="Search btn" onclick="search_form.submit()">
                    <img src="../img/close.svg" id="close-btn" alt="close btn" onclick="close_search()">
                </li>
            </ul> 
        </div>
    </nav>-->
    <!-- <a class="wa"
        href="https://wa.me/917201049049?text=Hello.%20I%20checked%20out%20your%20website%20and%20want%20to%20know%20more.">
        <img src="../img/wa.webp" alt="WhatsApp logo">
        <p>Let's Chat!</p>
        <script>
            window.onscroll = function () {
                if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
                    // the user has scrolled to the end of the page
                    document.querySelector(".wa").style.opacity = "0";
                } else {
                    document.querySelector(".wa").style.opacity = "1";
                }
            };
        </script> -->

    <!-- IDLE TIMER  -->
    <div id="idle-timer"
        style="position: absolute; top: 60px; right: 20px; background-color: #f8d7da; padding: 10px; border-radius: 5px; display: none;">
        Idle Time: <span id="idle-time">0</span> seconds
    </div>
    </a>
    <div class="sidebar">
        <div class="section-title">Choose Backplate</div>

        <div class="container backplate-selector">
            <div class="item" data-rows="one-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/1.png">
                </div>
                <p class="title">2 Modules</p>
            </div>
            <div class="item" data-rows="one-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/2.png">
                </div>
                <p class="title">3 Modules</p>
            </div>
            <div class="item" data-rows="one-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/3.png">
                </div>
                <p class="title">4 Modules</p>
            </div>
            <div class="item" data-rows="one-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/4.png">
                </div>
                <p class="title">6 Modules</p>
            </div>
            <div class="item" data-rows="one-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/6.png">
                </div>
                <p class="title">8 Modules</p>
            </div>
            <div class="item" data-rows="two-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/5.png">
                </div>
                <p class="title">8v Modules</p>
            </div>
            <div class="item" data-rows="two-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/7.png">
                </div>
                <p class="title">12 Modules</p>
            </div>
            <div class="item" data-rows="two-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/8.png">
                </div>
                <p class="title">16 Modules</p>
            </div>
            <div class="item" data-rows="three-liner" onclick="load_plate(this)">
                <div class="image">
                    <img src="img/backplates/9.png">
                </div>
                <p class="title">18 Modules</p>
            </div>
        </div>

        <div class="container component-selector">
            <p class="sub-section-heading"><i>Switches</i></p>
            <div class="switches">
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw1.png">
                    </div>
                    <p class="title">SSW1 (2M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw2.png">
                    </div>
                    <p class="title">SSW2 (2M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw1x2.png">
                    </div>
                    <p class="title">SSW1x2 (2M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw2x2.png">
                    </div>
                    <p class="title">SSW2x2 (2M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw2F.png">
                    </div>
                    <p class="title">SSW2F (4M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw4.png">
                    </div>
                    <p class="title">SSW4 (4M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw4F.png">
                    </div>
                    <p class="title">SSW4F (6M)</p>
                </div>

                <div class="item">
                    <div class="image">
                        <img src="img/components/Ssw6.png">
                    </div>
                    <p class="title">SSW6 (6M)</p>
                </div>
            </div>

            <p class="sub-section-heading"><i>Plugs</i></p>
            <div class="plugs">
                <div class="item">
                    <div class="image">
                        <img src="img/components/6A Plug.png">
                    </div>
                    <p class="title">6A Plug (2M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/6A 2pin Plug.png">
                    </div>
                    <p class="title">6A 2 Pin Plug (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/16A Plug.png">
                    </div>`
                    <p class="title">16A Plug (2M)</p>
                </div>
            </div>

            <p class="sub-section-heading"><i>Ports</i></p>
            <div class="ports">
                <div class="item">
                    <div class="image">
                        <img src="img/components/1A USB White.png">
                    </div>
                    <p class="title">1.0 A USB White (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/1A USB Black.png">
                    </div>
                    <p class="title">1.0A USB Black (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/2A USB White.png">
                    </div>
                    <p class="title">2.1 A USB White (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/HDMI White.png">
                    </div>
                    <p class="title">HDMI White (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/HDMI Black.png">
                    </div>
                    <p class="title">HDMI Black (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/RJ-11 White.png">
                    </div>
                    <p class="title">RJ-11 White (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/RJ-11 Black.png">
                    </div>
                    <p class="title">RJ-11 Black (1M)</p>
                </div>

            </div>

            <p class="sub-section-heading"><i>Sockets</i></p>
            <div class="sockets">
                <div class="item">
                    <div class="image">
                        <img src="img/components/TV Socket White.png">
                    </div>
                    <p class="title">TV Socket White (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/TV Socket Black.png">
                    </div>
                    <p class="title">TV Socket Black (1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Info Socket 6A White.png">
                    </div>
                    <p class="title">Info Socket 6A White(1M)</p>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="img/components/Info Socket 6A Black.png">
                    </div>
                    <p class="title">Info Socket 6A Black (1M)</p>
                </div>
            </div>

            <div class="item">
                <div class="image">
                    <img src="img/components/Blanking Plate.png">
                </div>
                <p class="title">Blanking Plate (1M)</p>
            </div>
        </div>

        <div class="container icon-selector">
        </div>

        <div class="container topplate-selector">
            <div class="item" onclick="load_top_plate(event, 'black')">
                <div class="image">
                    <img src="img/topplate/Black.png">
                </div>
                <p class="title">Black</p>
            </div>
            <div class="item" onclick="load_top_plate(event, 'matte-black')">
                <div class="image">
                    <img src="img/topplate/Matte_Black.png">
                </div>
                <p class="title">Matte Black</p>
            </div>
            <div class="item" onclick="load_top_plate(event, 'white')">
                <div class="image">
                    <img src="img/topplate/White.png">
                </div>
                <p class="title">White</p>
            </div>
            <div class="item" onclick="load_top_plate(event, 'own-bg')">
                <div class="image">
                    <img src="img/topplate/Own_Background.png">
                </div>
                <p class="title">Own Background</p>
            </div>
            <div class="item" onclick="load_top_plate(event, 'own-material')">
                <div class="image">
                    <img src="img/topplate/Own_Material.png">
                </div>
                <p class="title">Own Material</p>
            </div>
        </div>

        <div class="button-container">
            <button class="back disabled" id="back" onclick="">Back</a>
                <button class="next disabled" id="next" onclick="next_section()">Next</a>
                    <button class="disabled" id="download_svg" onclick="download_svg_as_file()">Save to Cart</button>
        </div>
    </div>

    <div class="board-preview" id="board-preview">
        <h1 id="intro_text">Select backplate to continue</h1>
        <div class="board-container" id="board">
        </div>
    </div>

    <script>
        document.getElementById("download_svg").addEventListener("click", function () {
            var svgData = content; // Replace with actual SVG data //content is from svg_generator.js file

            fetch("save_svg.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "data=" + encodeURIComponent(svgData)
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display server response
                })
                .catch(error => console.error("Error:", error));
        });
    </script>


</body>

</html>