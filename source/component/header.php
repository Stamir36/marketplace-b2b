        <div id="main_header" style="z-index: 1;">
           <header>
               <div class="header-innr">

                   <!-- Logo-->
                   <div class="header-btn-traiger is-hidden" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
                       <span></span></div>

                    <!-- Logo-->
                    <div id="logo">
                       <a href="<? echo $dns_store; ?>"> <img src="<? echo $dns_store; ?>assets/images/logo.png" alt=""></a>
                       <a href="<? echo $dns_store; ?>"> <img src="<? echo $dns_store; ?>assets/images/logo-light.png" class="logo-inverse"alt=""></a>
                   </div>

                   <!-- form search-->
                   <div class="head_search">
                        <form id="searchForm" action="/search" method="GET">
                            <div class="head_search_cont">
                                <input id="searchInput" name="q" value="" type="text" class="form-control" placeholder="<?php echo $SearchAll; ?>" autocomplete="off">
                                <i class="s_icon uil-search-alt"></i>
                            </div>

                            <!-- Search box dropdown -->
                            <div id="searchDropdown" uk-dropdown="pos: top; mode: click; animation: uk-animation-slide-bottom-small" class="dropdown-search display-hidden">
                                <ul id="searchResults" class="dropdown-search-list">
                                </ul>
                            </div>
                        </form>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(document).ready(function() {
                        // Обработчик события ввода текста в поле поиска
                        $('#searchInput').on('input', function() {
                            var query = $(this).val();
                            if (query.length >= 2) {
                                // Отправка AJAX-запроса на сервер для получения результатов поиска
                                $.ajax({
                                    url: '/search/search-results.php', // Замените на путь к вашему скрипту обработки поиска
                                    method: 'GET',
                                    data: { q: query },
                                    success: function(response) {
                                        // Обработка полученных результатов поиска
                                        var results = JSON.parse(response);
                                        displaySearchResults(results);
                                    }
                                });
                            } else {
                                // Скрыть выпадающий список при удалении текста из поля поиска
                                $('#searchDropdown').hide();
                            }
                        });

                        // Функция отображения результатов поиска
                        function displaySearchResults(results) {
                            var searchResults = $('#searchResults');
                            searchResults.empty();

                            searchResults.append('<li class="list-title"><?php echo $search_product; ?></li>');
                            if (results.length > 0) {
                                // Создание элементов списка результатов поиска
                                for (var i = 0; i < results.length; i++) {
                                    var result = results[i];
                                    var listItem = $('<li><a href="/product/?id=' + result.link + '"><img src="' + result.icon + '" alt=""><p> ' + result.name + ' <span> ' + result.store + ' </span> </p></a></li>');
                                    searchResults.append(listItem);
                                }
                            } else {
                                // Если нет результатов поиска, отобразить сообщение
                                var listItem = $('<div class="w-100 text-center"><ul role="list" class="p-0 divide-y divide-gray-200 dark:divide-gray-700"><div class="is-auto empty-cart-card"><div class="empty-cart has-text-centered m-4"><h2><? echo $search_none_1_txt; ?></h2><small><? echo $search_none_2_txt; ?></small></div></div></ul></div>');
                                searchResults.append(listItem);
                            }
                            searchResults.append('<li class="menu-divider"></li><li class="list-footer"> <a class="f-12" style="font-size: 12px;cursor: default;"><? echo $search_enter; ?> <kbd class="p-1 ml-1 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">Enter</kbd></a></li>');
                            $('#searchDropdown').show();
                        }
                    });

                    </script>

                   <!-- user icons -->
                   <div class="head_user">

                    <?php
                    
                        if(strlen($cook_id) > 0){
                            include 'header.user.login.php';
                        }else{
                            echo("
                                <div class='pc'>
                                    <a href='https://unesell.com/login/?go=uStore' class='button primary px-6' id='login_btn'>".$logins."</a>
                                    <a href='https://unesell.com/registration/' class='button outline-light circle' type='button' style='margin-left: 15px; border-color: #e6e6e6;  border-width: 1px;'>".$regs."</a>
                                </div>

                                <div class='mobile'>
                                    <a href='https://unesell.com/login/?go=uStore' class='button outline-light circle' type='button' style='margin-left: 15px; border-color: #e6e6e6;  border-width: 1px;'>".$lr."</a>
                                </div>
                            ");
                        }

                    ?>


                   </div>

               </div> <!-- / heaader-innr -->
           </header>

       </div>