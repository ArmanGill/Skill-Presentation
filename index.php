<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"/> -->
    <title>Shopping cart with javascript using local storage -- fullyworld web tutorials</title>
    <link rel="stylesheet" href="index.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script>
        
        function Delete(e){
            let items = [];
            JSON.parse(localStorage.getItem('items')).map(data=>{
                if(data.id != e.parentElement.parentElement.children[0].textContent){
                    items.push(data);
                }
            });
            localStorage.setItem('items',JSON.stringify(items));
            window.location.reload();
        };
    </script>
</head>
<body>
    <div class="main">
        <header id="header" class="header">
            <h1>D-Cart</h1>
            <div class="tabs">
                <div class="tab" id="cart-tab">
                    <p>0</p>
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="tab" id="about-tab">
                    <a href="about.php">About Me</a>
                </div>
            </div>
        </header><!-- /header -->
        <div class="itemsBox">
            <div class="item">
                <img src="https://i.pinimg.com/564x/bf/68/dd/bf68dd3b8f55fcbaaa94e0f5e2b5b33b.jpg" alt="Men's Solid Regular Fit T-Shirt"/>
                <div class="itemInfo">
                    <h1>God knows when</h1>
                    <p>$<span>34.99</span></p>
                    <a href="customer_details.php" title="add to cart" class="attToCart">Add to cart</a> 
                    <a href="customer_details.php" title="Buy-Now" class="attToCart">Buy-Now</a>
                </div>
            </div>
            <div class="item">
                <img src="https://oldnavy.gapcanada.ca/webcontent/0054/465/135/cn54465135.jpg"/>
                <div class="itemInfo">
                    <h1>Sharks</h1>
                    <p>$<span>29.99</span></p>
                    <a href="customer_details.php" title="add to cart" class="attToCart">Add to cart</a>
                    <a href="customer_details.php" title="Buy-Now" class="attToCart">Buy-Now</a>
              
                </div>
            </div>
            <div class="item">
                <img src="https://oldnavy.gapcanada.ca/webcontent/0054/332/178/cn54332178.jpg"/>
                <div class="itemInfo">
                    <h1>T-Rex Anotomy</h1>
                    <p>$<span>30</span></p>
                    <a href="customer_details.php" title="add to cart" class="attToCart">Add to cart</a>
                    <a href="customer_details.php" title="Buy-Now" class="attToCart">Buy-Now</a>
              
                </div>
                
            </div>
            
            
        </div>
    </div>
    <div class="cartBox">
        <div class="cart">
            <i class="fa fa-close"></i>
            <h1>Cart</h1>
            <table></table>
        </div>
    </div>


    <!-- script -->
    <script src="index.js"></script>
</body>
</html>
