<?php

    if(isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $endDate = $_POST['endDate'];
        $startDate = $_POST['startDate'];
    } else {
        $endDate = date("Y-m-d");
        $startDate = date("Y-m-d", strtotime("-7 days", strtotime($endDate)));
    }
    
    $conn = mysqli_connect('lillycover.com', 'root', 'cozmo1231', 'shop_data');
    // $sql = "SELECT * FROM order_list WHERE od_time >= '2022-04-01 00:00:00' AND od_time <= '2022-04-08 23:59:59' ORDER BY od_time DESC;";
    $sql = "SELECT * FROM order_list WHERE od_time >= '{$startDate} 00:00:00' AND od_time <= '{$endDate} 23:59:59' ORDER BY od_time DESC;";
    $result = mysqli_query($conn, $sql);
    $data = array();
    // $rowNum = 1;

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" 
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>

<body>
    <!--Top header Area-->
    <header>
        <div>
            <canvas id="myDoughnut" style="width:100%;max-width:500px;"></canvas>
        </div>
        <div>
            <canvas id="myLine" style="width:100%;max-width:500px"></canvas>
            <canvas id="myBar" style="width:100%;max-width:500px"></canvas>
        </div>
        <!-- <div>
            <canvas id="myBar" style="width:100%;max-width:500px"></canvas>
        </div> -->
    </header>

    <!--Nav Area-->
    <nav>
        <div>
            <button id="show" class="btn" type="submit" formmethod="post">에센스</button>
            <button class="btn" type="submit" formmethod="post">로션</button>
            <button class="btn" type="submit" formmethod="post">클렌징폼</button>
        </div>
        <div>
            <form>
                <input type="date" id="startDate" name="startDate" value="<?php echo $startDate ?>" required/>
                <input type="date" id="endDate" name="endDate" value="<?php echo $endDate ?>" placholder="1234" required/>
                <!-- <input type="date" id="startDate" name="startDate" value="123" required/>
                <input type="date" id="endDate" name="endDate" value="1234" placholder="1234" required/> -->
                <button class="btn" type="submit" formmethod="post">날짜 검색</button>
            </form>
        </div>
        <div>
            <button class="btn" type="submit" formmethod="post">오늘</button>
            <button class="btn" type="submit" formmethod="post">7일</button>
            <button class="btn" type="submit" formmethod="post">한달</button>
            <button type="button" onclick="back()">Back</button>
        </div>
    </nav>

    <!--Main Area-->
    <main>

    <?php 
    while ($row = mysqli_fetch_array($result)){
        array_push($data, array('od_id' => $row['od_id']));
        // print_r($row);
    ?>
 <!-- flip-card-container -->
        <div class="flip-card-container orderDetail" style="--hue: 170">
            <div class="flip-card">
                <div class="card-front">
                    <figure>
                        <div class="img-bg"></div>
                        <img src="https://images.unsplash.com/photo-1545436864-cd9bdd1ddebc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                            alt="Image 2">
                        <!-- <figcaption><?php echo $row['od_id'] ?></figcaption> -->

                         <?php
                            if (strpos($row['od_product'], '로션')) {
                        ?>
                            <!-- <figcaption><?php echo "Lotion"?></figcaption> -->
                            <figcaption>Lotion</figcaption>
                        <?php
                            }else if(strpos($row['od_product'], '에센스')){
                        ?>      
                            <!-- <figcaption><?php echo "Essence"?></figcaption> -->
                            <figcaption>Essencs</figcaption>
                        <?php 
                            }else{
                        ?>
                            <figcaption><?php echo "Form"?></figcaption>
                        <?php        
                            } 
                        ?>
                    </figure>

                    <ul>                  
                        <li><?php echo $row['od_name'] ?></li>
                        <li><?php echo $row['skin_code'] ?></li>
                        <li><?php echo $row['od_time'] ?></li>
                        <li><?php echo $row['od_status'] ?></li>
                    </ul>
                </div>

                <div class="card-back">
                    <figure>
                        <div class="img-bg"></div>
                        <img src="https://images.unsplash.com/photo-1545436864-cd9bdd1ddebc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                            alt="image-2">
                    </figure>

                    <button class="btnIndex"">주문상세보기</button>

                    <div class="design-container test">
                        <span class="design design--1"></span>
                        <span class="design design--2"></span>
                        <span class="design design--3"></span>
                        <span class="design design--4"></span>
                        <span class="design design--5"></span>
                        <span class="design design--6"></span>
                        <span class="design design--7"></span>
                        <span class="design design--8"></span>
                    </div>

                    <!-- <div style="display:none" class="add2"> -->
                    <div style="margin-bottom:150px; display:none" class="hideon" >
                        <ul>
                            <li><?php echo $row['od_name'] ?></li>
                            <li><a href="<?php echo $row['skin_code_qr']?>"><?php echo $row['skin_code'] ?></a></li>
                            <li><?php echo $row['od_d_tel'] ?></li>                  
                            <li><?php echo $row['od_product'] ?></li>
                            <li>수량 : <?php echo $row['od_qty'] ?></li>
                            <li><?php echo $row['od_status'] ?></li>
                            <li><?php echo $row['od_d_address']?></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }
    mysqli_close($conn);
    ?>
        <!-- /flip-card-container -->


    </main>
       <!--Footer Area-->
    <footer>
        <div>
            <p>Copyright ©주식회사 릴리커버 All rights reserved.        @Create by. yun</p>

        </div>
    </footer>

    <a href="https://abubakersaeed.netlify.app/designs/d4-flip-card" class="abs-site-link" rel="nofollow noreferrer"
            target="_blank">abs/designs/d4-flip-card</a>
</body>

<script type="text/javascript">

    // Doughnut Chart
    var xValues = ["IOS", "Android", "Web", "Something", "Anything"]
    var yValues = ["55","23","87","11","8"]
    var doughnutColor = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart ("myDoughnut", {
        type: "doughnut",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: doughnutColor,
                data:yValues
            }]
        },
        options:{
            title:{
                display: true,
                text: "접속 경로 통계"
            }
        }
    });

    // Line Chart
    var lineXvalues = [100,200,300,400,500,600,700,800,900,1000];

    new Chart("myLine", {
        type: "line",
        data: {
            labels: lineXvalues,
            datasets: [{ 
                data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
                borderColor: "red",
                fill: false
            }, { 
                data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
                borderColor: "green",
                fill: false
            }, { 
                data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
                borderColor: "blue",
                fill: false
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true, 
                text: "제품별 판매 추이"
            }
        }
    });

    // Bar Chart
    var BarXvalues = ["Italy", "France", "Spain", "USA", "Argentina"];
    var BarYvalues = [55, 49, 44, 24, 15];
    var barColors = ["red", "green","blue","orange","brown"];

    new Chart("myBar", {
        type: "bar",
        data: {
            labels: BarXvalues,
            datasets: [{
                backgroundColor: barColors,
                data: BarYvalues
            }]
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
                text: "World Wine Production 2018"
            }
        }
    });

    // $(".orderDetail").click(function(){
    //     var getIndex = infoArray[$(".orderDetail").index(this)]["od_id"];
    //     alert(getIndex);

    // });

    var infoArray;
    $(document).ready(function (){
        infoArray = <?php echo json_encode($data); ?>;
    });

    // $("#show").click(function(){
    //     $("figcaption").show("Lotion");
    //     // $("figcaption").show("Lotion");
    // });

    


    $(".btnIndex").click(function(){
        // var btn = $(".btnIndex").index(this);
        $("#hideon").show();
        $("#test").hide();
        $("#btnIndex").hide();

        // var btn = $(".btnIndex").index(this);
    });

    var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i) == null ? false : true;
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i) == null ? false : true;
    },
    any: function () {
        return (isMobile.Android() || isMobile.iOS());
    }
};

// 입력 된 링크를 전달하는 Bridge 함수
function outLink(link) {
    if (isMobile.any()) {
        if (isMobile.Android()) {
            android.bridge.outLink(link);
        } else if (isMobile.iOS()) {
            webkit.messageHandlers.outLink.postMessage(link);
        }
    }
}	

// Back Button 클릭 Bridge 함수
function back() {
    window.alert("message");
    if (isMobile.any()) {
        if (isMobile.Android()) {
            window.alert("message");
            android.bridge.back(true);
        } else if (isMobile.iOS()) {
            window.alert("IOS - message");
            webkit.messageHandlers.back.postMessage(true);

        } else {
            window.alert("ipad - message");
        }
    }
} 


   

</script>

</html>

