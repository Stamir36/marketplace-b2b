        <div class="main_sidebar" style="z-index: 1;">
           <div class="side-overlay" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></div>
       
           <!-- sidebar header -->
           <div class="sidebar-header">
               <!-- Logo-->
               <div id="logo">
                   <a href="<? echo $dns_store; ?>"> <img src="<? echo $dns_store; ?>assets/images/logo-light.png" alt=""></a>
               </div>
               <span class="btn-close" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></span>
           </div>
       
           <!-- sidebar Menu -->
           <div class="sidebar">
               <div class="sidebar_innr" data-simplebar>
       
                   <div class="sections">

                        <?php 
                            if(strlen($cook_id) > 0){

                                $res = $mysql_shop->query("SELECT count(*) FROM `shop` WHERE `USER_ID` = '$cook_id'");
                                $row = $res->fetch_row();
                                
                                if($row[0] > 0){
                                    echo('
                                    <a href="'.$dns_store.'new/" class="button secondary px-5 btn-more">
                                        <span id="more-veiw">'.$new_product_shop.'</span>
                                    </a>');
                                }else{
                                    echo('
                                    <a href="'.$dns_store.'new/?create=store" class="button secondary px-5 btn-more">
                                        <span id="more-veiw">'.$cstxt.'</span>
                                    </a>');
                                }
                            }

                            $url_now = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $url_now = explode('?', $url_now);
                            $url_now = $url_now[0];
                        ?>

                       <ul>
                           <li <? if($url_now == $dns_store){ echo('class="active"'); } ?> >
                               <a href="<?php echo $dns_store; ?>">
                                    <i class="fa fa-shopping-bag fa-2" aria-hidden="true"></i>
                                   <? echo $main_page_text; ?> </a>
                           </li>
                       </ul>

                       <ul>
                           <li <? if($url_now == $dns_store."categories/"){ echo('class="active"'); } ?>>
                               <a href="<?php echo $dns_store; ?>categories">
                                    <i class="fa fa-cubes fa-2" aria-hidden="true"></i>
                                    <? echo $category_page_text; ?> </a>
                           </li>
                       </ul>

                       <ul>
                           <li <? if($url_now == $dns_store."profile/"){ echo('class="active"'); } ?>>
                               <a href="<?php echo $dns_store; ?>profile/">
                                    <i class="fa fa-user fa-2" aria-hidden="true"></i>
                                    <? echo $my_page_txt; ?> </a>
                           </li>
                       </ul>

                   </div>
       
                   <!--  Optional Footer -->
                   <div class="w100" id="foot">
       
                        <div class="uk-flex uk-flex-between">
                            <button class="button circle language-buttom" type="button" aria-expanded="false"><? echo $language_select ?></button>
                                <div uk-dropdown="" class="uk-dropdown uk-dropdown-top-left" style="width: 99%;">
                                    <ul class="lang uk-nav uk-dropdown-nav">
                                        <!-- uk-active -->
                                        <li class="language-li"><a class="language-a" onclick="srtLang('ua')"><? echo $lang_ua ?></a></li>
                                        <li class="language-li"><a class="language-a" onclick="srtLang('en')"> <? echo $lang_en ?> </a></li>
                                    </ul>
                                </div>
                        </div>
                        
                        <hr>

                       <ul>
                           <li> <a href="https://unesell.com/service/support/"> <? echo $support_text; ?> </a></li>
                           <li> <a href="mailto:service@unesell.com"> <? echo $mailsend; ?> </a></li>
                           <li> <a href="https://unesell.com/service/rule/"> <? echo $rule_text; ?> </a></li>
                       </ul>
       
                       <ul></ul>
                       <div class="foot-content">
                           <p>uStore - <strong>Unesell Studio</strong></p>
                           <p>©<? echo date('Y'); ?> <strong>Мірошніченко Станіслав</strong></p>
                       </div>
       
                   </div>
       
       
       
               </div>
       
       
           </div>
       
       </div>