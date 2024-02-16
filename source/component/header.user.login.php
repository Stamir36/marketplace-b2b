                       <!-- notificiation icon  -->
                       <a href="#" class="opts_icon" uk-tooltip="title: <?php echo $notifications_text ?> ; pos: bottom ;offset:7">
                        <i class="fas fa-bell" style="width: 20px; height: 20px; margin-left: 3px; "></i>
                           
                           <?php
                                $res = $mysql->query("SELECT count(*) FROM `notifications` WHERE `user_id` = '$cook_id'");
                                $row = $res->fetch_row();
                                
                                if($row[0] > 0){
                                    echo("
                                        <span id='notify_count'>
                                        ".$row[0]."
                                        </span>
                                    ");
                                }
                            ?>
                       </a>


                       <!-- notificiation dropdown -->
                       <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                           class="dropdown-notifications display-hidden">                              
                           <!-- notivication header -->
                               <div class="dropdown-notifications-headline">
                                   <h4> <? echo $notifications_text; ?> </h4>
                                   <a href="https://unesell.com/account/settings/">
                                       <i class="icon-feather-settings"
                                           uk-tooltip="title: <? echo $notifications_settings_text ?> ; pos: left"></i>
                                   </a>
                               </div>
                           <!-- notification contents -->
                           <div class="dropdown-notifications-content" data-simplebar>
                               <!-- notiviation list -->
                               <ul id="notifi_clear">
                                    <?php
                                    $notifi = $mysql->query("SELECT * FROM `notifications` WHERE `user_id` = '$cook_id'");
                                    $mess = Array();
                                    $href = Array();
                                    $data = Array();

                                    while($result = $notifi->fetch_assoc()){
                                        $mess[] = $result['text'];
                                        $href[] = $result['href'];
                                        $data[] = $result['data'];
                                    }

                                    $num_notifi = 0;

                                        if(count($mess) == count($href) && count($mess) != 0 && count($href) != 0 ){
                                        while($num_notifi <= (count($mess) - 1)){
                                            echo("
                                            <li>
                                                <a href='".$href[$num_notifi]."'>
                                                    <span class='notification-avatar' style='height: 40px; width: 40px;'>
                                                        <img src='".$dns_store."assets/images/icons/notify.svg' alt='' style='width: 40px; height: 40px;'>
                                                    </span>
                                                    <span class='notification-text'>
                                                        ".$mess[$num_notifi]."
                                                        <br> <span class='time-ago' style='margin-left: 0px;'>".date("d.m.Y", strtotime($data[$num_notifi]))."</span>
                                                    </span>
                                                </a>
                                            </li>
                                            ");
                                            $num_notifi = $num_notifi + 1;
                                        }
                                    }else{
                                        echo("<a style='color: #db6724;cursor: default;text-align: center;margin: 60px;width: 100%; display: table-caption;height: 100%;margin-top: 80%;' id='none_notify'>Уведомлений нет</a>");
                                    }
                                    ?>
                                </ul>
                                <a style='color: #db6724;cursor: default;text-align: center;margin: 60px;width: 100%; display: none;height: 100%;margin-top: 80%;' id='none_notify'>Уведомлений нет</a>
                           </div>
                            <?php
                                if($num_notifi > 0){
                                    echo("
                                        <a id='notifi_clear_btn' onclick='claer_notify()' class='py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700' style='display: block;margin-top: 10px;margin-right: 15px !important;text-align: center;'>
                                            <span> ".$clear_my_notify." </span>
                                        </a>
                                    ");
                                }
                            ?>
                       </div>


                       <!-- profile -image -->
                       <a class="opts_account" uk-tooltip="title: <? echo $profile_txt ?> ; pos: bottom ;offset:7"> <img src="https://unesell.com/data/users/avatar/<?php echo $user['avatar'];?>" alt=""></a>

                       <!-- profile dropdown-->
                       <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                           class="dropdown-notifications rounded display-hidden">

                           <!-- User Name / Avatar -->
                           <div class="dropdown-user-details">
                                <div class="dropdown-user-cover">
                                    <img src="<?php echo $user['imgBackground'];?>" alt="" style="margin-left: 2px;">
                                </div>
                                <div class="dropdown-user-avatar">
                                    <img src="https://unesell.com/data/users/avatar/<?php echo $user['avatar'];?>" alt="">
                                </div>
                                <div class="dropdown-user-name"><?php echo $user['name'];?></div>
                            </div>

                           <ul class="dropdown-user-menu" style="padding-top: 15px;">
                               <li><a href="https://unesell.com/account/"> <i class="fas fa-user"></i> <? echo $my_profile_txt ?> </a> </li>
                               <li><a href="https://unesell.com/account/settings/"> <i class="fas fa-user-cog"></i> <? echo $my_settings_txt ?> </a> </li>
                               <li><a href="https://unesell.com/service/out.php"> <i class="fas fa-sign-out-alt"></i> <? echo $my_out_txt ?> </a> </li>
                           </ul>

                           <hr class="m-0">
                           <ul class="dropdown-user-menu">

                           <?php

                                $stores = $mysql_shop->query("SELECT * FROM `shop` WHERE `USER_ID` = '$cook_id'");
                                $name = Array();
                                $icon = Array();
                                $link = Array();
                                $Type = Array();
                                
                                while($result = $stores->fetch_assoc()){
                                    $name[] = $result['Name'];
                                    $icon[] = $result['Icon'];
                                    $link[] = $result['LINK_ID'];
                                    $Type[] = $result['Type'];
                                }

                                $num_notifi = 0;

                                
                                if(count($name) == count($icon) && count($icon) != 0 && count($link) != 0 ){
                                    while($num_notifi <= (count($name) - 1)){
                                        echo("
                                        <li><a href='".$dns_store."shop/?id=".$link[$num_notifi]."' class='bg-secondery'> <i><img src='".$dns_store."datafiles/store/".$icon[$num_notifi]."' style='width: 80%; border-radius: 25px;'></i>
                                            <div class='fs-8'> "); 
                                            if($Type[$num_notifi] == "0"){
                                                echo $shop_text_b;
                                            }else{
                                                echo $shop_text_u;
                                            }
                                            echo(" <span> ".$name[$num_notifi]." </span>  </div>
                                        </a></li>
                                        ");
                                        $num_notifi = $num_notifi + 1;
                                    }
                                }
                            ?>

                               <li>
                                    <a href="<? echo $dns_store; ?>new/?create=store" class="bg-secondery"> <i class="fas fa-plus"></i>
                                        <div> <? echo $cstxt ?> <span class="fs-8"> <? echo $cstxt_sub ?> </span> </div>
                                   </a>
                               </li>
                               
                           </ul>

                       </div>