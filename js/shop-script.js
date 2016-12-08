$(document).ready(function() {
  //Inicjalizacja modułu AngularJS
  var myAppModule = angular.module('myApp', ['ngRoute', 'ui.bootstrap']);

  myAppModule.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
  }]);

  //Filter dla paginacji
  myAppModule.filter('startFrom', function() {
    return function(input, start) {
      if (input) {
        start = +start;
        return input.slice(start);
      }
      return [];
    }
  });
//Filter dla usunięcia składni html
    myAppModule.filter('htmlToPlaintext', function() {
    return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
  });

  //Inicjalizacja kontrolera 
  myAppModule.controller('ProductController', function($scope, $http, $timeout) {
    $scope.newshow = function(data){
      $scope.newshow=1;
    }
    $scope.shows = 2;
    $scope.logcheck = function() {
      var reglogin = $("#reg_login").val();
      $http.post("/reg/check_login.php?reg_login=" + reglogin).success(function(responce) {
        return responce;
      });
    };

    //Metoda kontrolera do generacji hasła
    $scope.generate = function() {
      $http.post('/functions/genpass.php').success(function(data) {
        $('#reg_pass').val(data);
      });
    };

    //Metoda do autentyfikacji użytkownika
    $scope.buttonAuth = function() {
      var auth_login = $("#auth_login").val();
      var auth_pass = $("#auth_pass").val();
      if ($("#rememberme").prop('checked')) {
        auth_rememberme = 'yes';
      } else { auth_rememberme = 'no'; }
      $http({
        method: "POST",
        url: "/include/auth.php",
        data: "login=" + auth_login + "&pass=" + auth_pass + "&rememberme=" + auth_rememberme
      }).success(function(data) {

        if (data == 'yes_auth') {
          location.reload();
        } else {
          $("#message-auth").slideDown(400);
          $(".auth-loading").hide();
          $("#button-auth").show();
        }
      });
    };

    //Funkcja odsyłająca nowe hasło użytkoniku
    $scope.remind = function() {
      var recall_email = $("#remind-email").val();
      $http.post("/include/remind-pass.php?email=" + recall_email).success(function() {
        setTimeout($(".response").val("Hasło zostało odesłane na podany email"), 500);
      });
    };

    //Funkcja wylogowania z profilu
    $scope.logout = function() {
      $http.post('/include/logout.php').success(function(data) {
        if (data == 'logout') {
          location.reload();
        }
      });

    };

    //Funkcja rejestracji nowego użytkownika
    $scope.reghandler = function() {
      // $scope.customer = {}; nie rób tego!!!
      $http({
        method: 'POST',
        url: '/reg/handler_reg.php',
        data: $scope.customer,
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      });
    }

    //Filtrowanie i sortowanie towarów

    $http.post('/include/search_eng.php').success(function(data) {
      $scope.list = data;
      $scope.currentPage = 1;
      $scope.entryLimit = 8;
      $scope.filteredItems = $scope.list.length;
      $scope.totalItems = $scope.list.length;
    });
    $scope.fetch_search = function(data) {
      var typy = data;
      $http.get("/include/search_eng.php?types=" + typy).success(function(data) {
        $scope.list = data;
        $scope.currentPage = 1;
        $scope.entryLimit = 8;
        $scope.filteredItems = $scope.list.length;
        $scope.totalItems = $scope.list.length;
      });
    };

    $scope.fetch_searching = function(data) {
      var modeli = data;
      $http.get("/include/search_eng.php?models=" + modeli).success(function(data) {
        $scope.list = data;
        $scope.currentPage = 1;
        $scope.entryLimit = 8;
        $scope.filteredItems = $scope.list.length;
        $scope.totalItems = $scope.list.length;
      });
    };
    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
      $timeout(function() {
        $scope.filteredItems = $scope.filtered.length;
      }, 10);
    };
    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    };

 
    //Image resizing 
    // $scope.resize_img = function(picture) {
    //   var img = new Image();
    //   img.onload = function() {
    //     var c = $(".ngImage").attr('src','./upload_images/picture');
    //     var ctx = c.getContext("2d");
    //     ctx.drawImage(img, 150, 150);
    //     $('.ngImage').attr('src', canvas.toDataURL("image/jpeg"));
    //   };
    // };





  });

  // Slajder wiadomości paneli bocznej
  $("#newsticker").jCarouselLite({
    vertical: true,
    hoverPause: true,
    btnPrev: "#news-prev",
    btnNext: "#news-next",
    visible: 3,
    auto: 3000,
    speed: 500
  });
  loadcart();

  //Sortowanie wedle kategorii paneli bocznej
  $("#select-sort").click(function() {
    $("#sorting-list").slideToggle(200);
  });

  $('#block-category > ul > li > a').click(function() {
    if ($(this).attr('class') != 'active') {
      $('#block-category > ul > li > ul').slideUp(400);
      $(this).next().slideToggle(400);
      $('#block-category > ul > li > a').removeClass('active');
      $(this).addClass('active');
      $.cookie('select_cat', $(this).attr('id'));
    } else {
      $('#block-category > ul > li > a').removeClass('active');
      $('#block-category > ul > li > ul').slideUp(400);
      $.cookie('select_cat', '');
    }
  });
  if ($.cookie('select_cat') != '') {
    $('#block-category > ul > li > #' + $.cookie('select_cat')).addClass('active').next().show();
  }
  // Sprawdzenie poprawności kapci
  $('#reloadcaptcha').click(function() {
    $('#block-captcha > img').attr("src", "/reg/reg_captcha.php?r=" + Math.random());
  });

  //Odsłony formy logowania
  $('.top-auth').toggle(
    function() {
      $(".top-auth").attr("id", "active-button");
      $("#block-top-auth").fadeIn(200);
    },
    function() {
      $(".top-auth").attr("id", "");
      $("#block-top-auth").fadeOut(200);
    }
  );

  //Funkcja zmiany stylu wyświetlania towarów
  $("#style-grid").click(function() {
    $("#style-grid").attr("src", "/images/icon-grid-active.png");
    $("#style-list").attr("src", "/images/icon-list.png");
    $.cookie('select_style', 'grid');
  });

  $("#style-list").click(function() {
    $("#style-list").attr("src", "/images/icon-list-active.png");
    $("#style-grid").attr("src", "/images/icon-grid.png");
    $.cookie('select_style', 'list');
  });
  if ($.cookie('select_style') == 'grid') {
    $("#style-grid").attr("src", "/images/icon-grid-active.png");
    $("#style-list").attr("src", "/images/icon-list.png");
  } else {
    $("#style-list").attr("src", "/images/icon-list-active.png");
    $("#style-grid").attr("src", "/images/icon-grid.png");
  };

  //Funkcja wyświetlania informacji o stanie kosza
  function loadcart() {
    $.ajax({
      type: "POST",
      url: "/include/loadcart.php",
      dataType: "html",
      cache: false,
      success: function(data) {
        if (data == "0") {
          $("#block-basket > a").html("Koszyk pusty");
        } else {
          $("#block-basket > a").html(data);
        }
      }
    });
  };

  //Animacja dla paneli przypomniania hasła
  $('#remindpass').click(function() {
    $('#input-email-pass').fadeOut(200, function() {
      $('#block-remind').fadeIn(300);
    });
  });
  $('#prev-auth').click(function() {

    $('#block-remind').fadeOut(200, function() {
      $('#input-email-pass').fadeIn(300);
    });
  });
  $('#auth-user-info').toggle(
    function() {
      $("#block-user").fadeIn(100);
    },
    function() {
      $("#block-user").fadeOut(100);
    }
  );

  function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
  }
  //Przycisk akceptacji zakupu
  $('#confirm-button-next').click(function(e) {
    var order_name = $("#order_name").val();
    var order_surname = $("#order_surname").val();
    var order_email = $("#order_email").val();
    var order_phone = $("#order_phone").val();
    var order_address = $("#order_address").val();
    if (!$(".order_delivery").is(":checked")) {
      $(".label_delivery").css("color", "#E07B7B");
      send_order_delivery = '0';
    } else {
      $(".label_delivery").css("color", "black");
      send_order_delivery = '1';
      if (order_name == "" || order_name.length > 50) {
        $("#order_name").css("borderColor", "#FDB6B6");
        send_order_name = '0';
      } else {
        $("#order_name").css("borderColor", "#DBDBDB");
        send_order_name = '1';
      }
      if (order_surname == "" || order_surname.length > 50) {
        $("#order_surname").css("borderColor", "#FDB6B6");
        send_order_surname = '0';
      } else {
        $("#order_surname").css("borderColor", "#DBDBDB");
        send_order_surname = '1';
      }
      if (isValidEmailAddress(order_email) == false) {
        $("#order_email").css("borderColor", "#FDB6B6");
        send_order_email = '0';
      } else {
        $("#order_email").css("borderColor", "#DBDBDB");
        send_order_email = '1';
      }
      if (order_phone == "" || order_phone.length > 50) {
        $("#order_phone").css("borderColor", "#FDB6B6");
        send_order_phone = '0';
      } else {
        $("#order_phone").css("borderColor", "#DBDBDB");
        send_order_phone = '1';
      }



      if (order_address == "" || order_address.length > 150) {
        $("#order_address").css("borderColor", "#FDB6B6");
        send_order_address = '0';
      } else {
        $("#order_address").css("borderColor", "#DBDBDB");
        send_order_address = '1';
      }

    }

    if (send_order_delivery == "1" && send_order_name == "1" && send_order_surname == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1") {

      return true;
    }

    e.preventDefault();

  });



  $('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function() {
    var tid = $(this).attr("tid");
    $.ajax({
      type: "POST",
      url: "/include/addtocart.php",
      data: "id=" + tid,
      dataType: "html",
      cache: false,
      success: function(data) {
        loadcart();
      }
    });

  });




  function fun_group_price(intprice) {

    var result_total = String(intprice);
    var lenstr = result_total.length;

    switch (lenstr) {
      case 4:
        {
          groupprice = result_total.substring(0, 1) + " " + result_total.substring(1, 4);
          break;
        }
      case 5:
        {
          groupprice = result_total.substring(0, 2) + " " + result_total.substring(2, 5);
          break;
        }
      case 6:
        {
          groupprice = result_total.substring(0, 3) + " " + result_total.substring(3, 6);
          break;
        }
      case 7:
        {
          groupprice = result_total.substring(0, 1) + " " + result_total.substring(1, 4) + " " + result_total.substring(4, 7);
          break;
        }
      default:
        {
          groupprice = result_total;
        }
    }
    return groupprice;
  }



  $('.count-minus').click(function() {

    var iid = $(this).attr("iid");

    $.ajax({
      type: "POST",
      url: "/include/count-minus.php",
      data: "id=" + iid,
      dataType: "html",
      cache: false,
      success: function(data) {
        $("#input-id" + iid).val(data);
        loadcart();


        var priceproduct = $("#tovar" + iid + " > p").attr("price");

        result_total = Number(priceproduct) * Number(data);

        $("#tovar" + iid + " > p").html(fun_group_price(result_total) + " zł");
        $("#tovar" + iid + " > h5 > .span-count").html(data);

        summary_price();
      }
    });

  });

  $('.count-plus').click(function() {

    var iid = $(this).attr("iid");

    $.ajax({
      type: "POST",
      url: "/include/count-plus.php",
      data: "id=" + iid,
      dataType: "html",
      cache: false,
      success: function(data) {
        $("#input-id" + iid).val(data);
        loadcart();


        var priceproduct = $("#tovar" + iid + " > p").attr("price");

        result_total = Number(priceproduct) * Number(data);

        $("#tovar" + iid + " > p").html(fun_group_price(result_total) + " zł");
        $("#tovar" + iid + " > h5 > .span-count").html(data);

        summary_price();
      }
    });

  });

  $('.count-input').keypress(function(e) {

    if (e.keyCode == 13) {

      var iid = $(this).attr("iid");
      var incount = $("#input-id" + iid).val();

      $.ajax({
        type: "POST",
        url: "/include/count-input.php",
        data: "id=" + iid + "&count=" + incount,
        dataType: "html",
        cache: false,
        success: function(data) {
          $("#input-id" + iid).val(data);
          loadcart();


          var priceproduct = $("#tovar" + iid + " > p").attr("price");

          result_total = Number(priceproduct) * Number(data);


          $("#tovar" + iid + " > p").html(fun_group_price(result_total) + " zł");
          $("#tovar" + iid + " > h5 > .span-count").html(data);
          summary_price();

        }
      });
    }
  });

  function summary_price() {

    $.ajax({
      type: "POST",
      url: "/include/summary_price.php",
      dataType: "html",
      cache: false,
      success: function(data) {

        $(".summary-price > strong").html(data);

      }
    });

  }


  $('#button-send-review').click(function() {

    var name = $("#name_review").val();
    var good = $("#good_review").val();
    var bad = $("#bad_review").val();
    var comment = $("#comment_review").val();
    var iid = $("#button-send-review").attr("iid");

    if (name != "") {
      name_review = '1';
      $("#name_review").css("borderColor", "#DBDBDB");
    } else {
      name_review = '0';
      $("#name_review").css("borderColor", "#FDB6B6");
    }

    if (good != "") {
      good_review = '1';
      $("#good_review").css("borderColor", "#DBDBDB");
    } else {
      good_review = '0';
      $("#good_review").css("borderColor", "#FDB6B6");
    }

    if (bad != "") {
      bad_review = '1';
      $("#bad_review").css("borderColor", "#DBDBDB");
    } else {
      bad_review = '0';
      $("#bad_review").css("borderColor", "#FDB6B6");
    }




    if (name_review == '1' && good_review == '1' && bad_review == '1') {
      $("#button-send-review").hide();
      $("#reload-img").show();

      $.ajax({
        type: "POST",
        url: "/include/add_review.php",
        data: "id=" + iid + "&name=" + name + "&good=" + good + "&bad=" + bad + "&comment=" + comment,
        dataType: "html",
        cache: false,
        success: function() {
          setTimeout("$.fancybox.close()", 1000);
        }
      });
    }
  });


});
