<?php
include "include/db_connect.php";
include "functions/functions.php";
session_start();
include "include/auth_cookie.php";
?>

<!DOCTYPE html>
<html lang="pl" ng-app='myApp'>

<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
  <link href="css/reset.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> 
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />
  
  <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
  <script type="text/javascript" src="/js/shop-script.js"></script>

  <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
  <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
  <script type="text/javascript" src="/js/TextChange.js"></script>

  <title>Poszukiwanie </title>
</head>

<body ng-controller="ProductController">
  <div id="block-body">
    <?php
    include "include/block-header.php";
    ?>
    <div id="block-right">
      <?php
      include "include/block-category.php";
      include "include/block-parameter.php";
      include "include/block-news.php";
      ?>
    </div>

    <div id="block-content">
      <div id="block-sorting">
        <p id="nav-breadcrumbs"><a href="index.php" >Strona Główna</a> \ <span>Wszystkie towary</span></p>
        <ul id="options-list">
          <li>Rodzaj: </li>
          <li ><img id="style-grid" src="/images/icon-grid.png" ng-click="shows=1"/></li>
          <li><img id="style-list" src="/images/icon-list.png" ng-click="shows=2"/></li>

        </ul>
      </div>


      <div class="row">
        <div class="col-lg-12" ng-show="filteredItems > 0">
          <table class="table table-striped table-bordered">
            <thead>
              <th></th>
              <th><a ng-click="sort_by('title');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><a ng-click="sort_by('price');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th></th>
              <th></th>
            </thead>

            <tbody class="table-cont" ng-show="shows==2">
              <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                <td><img class="ngImage" ng-src="./upload_images/{{(data.image)}}">
                </td>
                <td>
                 <p class="style-title-grid" ><a ng-href="view_content.php?id='{{data.products_id}}'" >{{data.title}}</a></p>
               </td>
               <td><div class="newsize2">{{data.price}} zł</div></td>
               <td><div class="newsize">{{data.mini_features | htmlToPlaintext }}</div></td>
               <td>
                <ul class="reviews-and-counts-grid">
                  <li><img src="/images/eye-icon.png" /><p>{{data.model_id}}</p></li>
                  <li><img src="/images/comment-icon.png" /><p>{{data.count }}</p></li>
                </ul><a class="add-cart-style-grid" tid="{{products_id}}" ></a>
               </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-lg-12" ng-show="filteredItems == 0">
          <div class="col-lg-12">
            <h4>Nie znaleziono towarów</h4>
          </div>
        </div>
        <div class="col-lg-12" ng-show="filteredItems > 0">    
          <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>


        </div>






      </div>

      <?php
      include "include/block-footer.php";
      ?>
    </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.3/angular.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.3/angular-route.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap.min.js"></script>
  </body>
  </html>
