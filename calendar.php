<?php
// Set your timezone
date_default_timezone_set('Asia/Jakarta');
// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}
// Check format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}
// Today
$today = date('Y-m-j', time());
// For H3 title
$html_title = date('F Y', $timestamp);
$year_title = date('Y', $timestamp);
// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
// You can also use strtotime!
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));
// Number of days in the month
$day_count = date('t', $timestamp);
 
// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 0, date('Y', $timestamp)));
//$str = date('w', $timestamp);
// Create Calendar!!
$weeks = array();
$week = '';
// Add empty cell
$week .= str_repeat('<td></td>', $str);
$months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
for ( $day = 1; $day <= $day_count; $day++, $str++) {
     
    $date = $ym . '-' . $day;
     
    if ($today == $date) {
        $week .= '<td class="today"><b>' . $day .'</b>'; 
        $week .= '<br>Rp. 200,000,-<br>17 kamar'; 
    } else {
        $week .= '<td><b>' . $day . '</b>';
        $week .= '<br>Rp. 200,000,-<br>17 kamar'; 
    }
    $week .= '</td>';
     
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        // Prepare for new week
        $week = '';
    }
}
?>
<!DOCTYPE html>
<html>
    <title>Calendar Template</title>
    <head>
        <!-- <BASE href="pms-staging/templates/calendar.php"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/materialize.css">
        <link rel="stylesheet" href="css/materialize.min.css">
        <script src="js/materialize.js"></script>
        <script src="js/materialize.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <script type="text/javascript">
            $(document).ready(function(){
                $('.dropdown-trigger').dropdown();
                $('.calendar-table tbody tr td').click(function(){
                    if(!$(this).hasClass('selected-date')){
                        $(this).parent().parent().find('td').removeClass('selected-date');
                        $(this).addClass('selected-date');
                    } else {
                        $(this).toggleClass('selected-date');
                    }
                });
                $('.calendar-table tbody tr td').hover(function(){
                    if(!$(this).hasClass('selected-date')){
                        $(this).parent().parent().find('td').removeClass('selected-date');
                        $(this).addClass('selected-date');
                    } else {
                        $(this).toggleClass('selected-date');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-center bg-info">
                            <div class="row card-header-row color-white">
                                <div class="col-md-12 d-block d-sm-none">
                                    <p class="year-title"><?php echo $year_title; ?></p>
                                </div>
                                <div class="col-md-3 col-2 text-left">
                                    <a href='?ym=<?php echo $prev ?>' class="arrow-links"><i class="fas fa-chevron-left"></i></a>
                                </div>
                                <div class="col-md-3 col-4 text-right calendar-month-title">
                                    <!-- May 2019 -->
                                    <!-- <div class="dropdown"> -->
                                    <a class='dropdown-trigger btn btn-aliceblue' href='#' data-target='dropdown1'><?php echo $html_title; ?></a>
                                    <!-- <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    </button> -->
                                    <ul id="dropdown1" class="dropdown-content">
                                        <?php foreach($months as $index => $month) { ?>
                                            <?php $index = $index+1; if($index<10) {?>
                                                <li><a href="?ym=<?php echo date('Y').'-0'.$index; ?>"><?php echo $month.' '.date('Y'); ?></a></li>
                                            <?php } elseif($index>=10) { ?>
                                                <li><a href="?ym=<?php echo date('Y').'-'.$index; ?>"><?php echo $month.' '.date('Y'); ?></a></li>
                                                <!-- <li><a href="#">BBB</a></li>
                                                <li><a href="#">CCC</a></li> -->
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <!-- </div> -->
                                </div>
                                <div class="col-md-3 col-4 text-right">
                                    <button class="btn btn-primary btn-mobile btn-aliceblue" onclick="window.location.href='calendar.php';">Today</button>
                                </div>
                                <div class="col-md-3 col-2 text-right">
                                    <a href='?ym=<?php echo $next ?>' class="arrow-links"><i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table calendar-table table-bordered">
                                        <thead>    
                                            <tr>
                                                <th>Senin</th>
                                                <th>Selasa</th>
                                                <th>Rabu</th>
                                                <th>Kamis</th>
                                                <th>Jumat</th>
                                                <th>Sabtu</th>
                                                <th>Minggu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($weeks as $week){
                                                    echo $week;
                                                }
                                            ?>
                                        </tbody>
                                        <!-- <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    2
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    3
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    4
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    5
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    6
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                                <td>
                                                    7
                                                    <br>Rp. 200,000,-
                                                    <br>17 kamar
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>9<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>10<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>11<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>12<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>13<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>14<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                            </tr>
                                            <tr>
                                                <td>15<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>16<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>17<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>18<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>19<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>20<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>21<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                            </tr>
                                            <tr>
                                                <td>22<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>23<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>24<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>25<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>26<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td class="today">27<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                                <td>28<br>Rp. 200,000,-
                                                    <br>17 kamar</td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>