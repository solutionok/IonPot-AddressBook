<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once 'favicon.php'; ?>
<title>List - <?php echo APP_NAME; ?></title>
<link href="<?php echo WORK_ROOT; ?>view/css/style.css" rel="stylesheet"
    type="text/css" />
<script src="<?php echo WORK_ROOT; ?>vendor/jquery/jquery-3.2.1.min.js"
    type="text/javascript"></script>
<script src="<?php echo WORK_ROOT; ?>view/js/common.js"></script>
<script src="<?php
echo WORK_ROOT;

?>view/js/modal.js"></script>
<script src="<?php

echo WORK_ROOT?>view/js/modal.js"></script>


       <style>
html {
  font-family: sans-serif;
  line-height: 1.15;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
   }

body {
  margin: 0; }
footer,
header,
section {
  display: block; }

h1 {
  font-size: 2em;
  margin: 0.67em 0; }

/**
 * 1. Remove the gray background on active links in IE 10.
 * 2. Remove gaps in links underline in iOS 8+ and Safari 8+.
 */
a {
  background-color: transparent;
  /* 1 */
  -webkit-text-decoration-skip: objects;
  /* 2 */ }

/**
 * Remove the outline on focused links when they are also active or hovered
 * in all browsers (opinionated).
 */
a:active,
a:hover {
  outline-width: 0; }

body {
  color: #333;
  font-family: 'Roboto', sans-serif;
  background-color: #f5f5f5; }
  body.cold-palette p::-moz-selection, body.cold-palette h1::-moz-selection, body.cold-palette h2::-moz-selection, body.cold-palette a::-moz-selection {
    background-color: #eeeeff; }
  body.cold-palette p::selection, body.cold-palette h1::selection, body.cold-palette h2::selection, body.cold-palette a::selection {
    background-color: #eeeeff; }
  body.cold-palette .circle {
    background: -webkit-linear-gradient(left, #82a8e0, #da6bbd);
    background: linear-gradient(to right, #82a8e0, #da6bbd); }
  body.cold-palette .circle-header {
    text-shadow: 5px 5px #e07fc1; }
  body.cold-palette .btn-pink {
    color: #e07fc1;
    border: 1px solid #eaa8d5; }
    body.cold-palette .btn-pink:hover {
      color: #fff;
      border: 1px solid transparent; }
      body.cold-palette .btn-pink:hover:before {
        background: -webkit-linear-gradient(left, #82a8e0, #da6bbd);
        background: linear-gradient(to right, #82a8e0, #da6bbd); }

.content {
 padding-top: 50px;
    width: 100%;
    margin: 0 auto;
    overflow: auto;
    text-align: center;
}
  @media (max-width: 720px) {
    .content {
      padding-top: 5px;} }
  .content .circle {
    width: 304px;
    height: 304px;
    text-align: center;
    color: #fff;
    border-radius: 50%;
  display: inline-block;
    -webkit-shape-outside: circle() margin-box;
    shape-outside: circle() margin-box;
    margin: 36px; }
    @media (max-width: 720px) {
      .content .circle {
        width: 250px;
        height: 250px;
        float: none;
        margin: auto; } }
    .content .circle .circle-header {
      font-family: 'Roboto Slab', serif;
      color: #fff;
      margin-top: 120px;
      font-size: 90px;
      line-height: 12px;
      letter-spacing: 4px; }
      @media (max-width: 720px) {
        .content .circle .circle-header {
          padding-top: 100px;
          margin-top: 20px;
          font-size: 82px;
          line-height: 10px; } }
    .content .circle .circle-text {
      line-height: 0;
      font-size: 14px;
      font-weight: 100;
      letter-spacing: 3px; }

.footer {
  width: 720px;
  margin: 0 auto;
  text-align: center; }
  @media (max-width: 720px) {
    .footer {
      width: 90%; } }


.button-list {
  margin-top: 40px;
  text-decoration: none; }
  @media (max-width: 720px) {
    .button-list {
      margin-top: 30px; } }

ul.button-list {
  padding-left: 0; }

.button-list li {
  display: inline-block;
  list-style: none;
  font-size: 13px;
  font-size: 1.3em;
  padding: 20px;
  font-size: 14px;
  font-family: 'Open Sans', sans-serif; }
  @media (max-width: 720px) {
    .button-list li {
      padding-right: 10px; } }

.btn-pink {
min-width:160px;
  background-size: 100%;
  text-decoration: none;
  border-radius: 1.60rem;
  cursor: pointer;
  display: inline-block;
  padding: 1rem 1.5rem;
  position: relative;
  z-index: 100; }
  @media (max-width: 720px) {
    .btn-pink {
      padding: 0.8rem 1.2rem;
      font-size: 12px; } }
  .btn-pink:before {
    border-radius: inherit;
    -webkit-transition: opacity 0.40s ease-out;
    transition: opacity 0.40s ease-out;
    content: '';
    display: block;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    width: 100%;
    z-index: -100; }
  .btn-pink:hover:before {
    opacity: 1; }

        </style>
</head>
    <body class="cold-palette">
    <div id="wrapper">
    <?php
    require_once "admin-header.php";
    ?>

        <div class="content">
            <div class="circle">
                <h1 class="circle-header">
                    404
                </h1>
                <p class="circle-text">
                    [Page Not Found!]
                </p>
            </div>
            <ul class="button-list">
                <li onclick="goBack()"><a href="#" class="btn-pink">Take me back</a></li>
                <li ><a href="<?php
                    echo WORK_ROOT;
                    ?>contact/" class="btn-pink">Home</a></li>
            </ul>

        </div>

    </div>
    <script>
function goBack() {
    window.history.back();
}
</script>
</body>
</html>