 <!DOCTYPE html>
<html>
<head>
<title>Page Title</title>

    <link rel="stylesheet" href="{{ asset('static/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/bootstrap/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/bootstrap-table/bootstrap-table.css') }}">


</head>
<body>

        <table id="table"
           data-toggle="table"
           data-filter-control="true"
           data-filter-show-clear="true">
        <thead>
        <tr>
            <th data-field="id">ID</th>
            <th data-field="name" data-filter-control="input">Item Name</th>
            <th data-field="price" data-filter-control="select">Item Price</th>
        </tr>
        </thead>
        <tbody><tr data-index="0"> <td style="">0</td> <td style="">Item 0</td> <td style="">$0</td> </tr><tr data-index="1"> <td style="">1</td> <td style="">Item 1</td> <td style="">$1</td> </tr><tr data-index="2"> <td style="">2</td> <td style="">Item 2</td> <td style="">$2</td> </tr><tr data-index="3"> <td style="">3</td> <td style="">Item 3</td> <td style="">$3</td> </tr><tr data-index="4"> <td style="">4</td> <td style="">Item 4</td> <td style="">$4</td> </tr><tr data-index="5"> <td style="">5</td> <td style="">Item 5</td> <td style="">$5</td> </tr><tr data-index="6"> <td style="">6</td> <td style="">Item 6</td> <td style="">$6</td> </tr><tr data-index="7"> <td style="">7</td> <td style="">Item 7</td> <td style="">$7</td> </tr><tr data-index="8"> <td style="">8</td> <td style="">Item 8</td> <td style="">$8</td> </tr><tr data-index="9"> <td style="">9</td> <td style="">Item 9</td> <td style="">$9</td> </tr><tr data-index="10"> <td style="">10</td> <td style="">Item 10</td> <td style="">$10</td> </tr><tr data-index="11"> <td style="">11</td> <td style="">Item 11</td> <td style="">$11</td> </tr><tr data-index="12"> <td style="">12</td> <td style="">Item 12</td> <td style="">$12</td> </tr><tr data-index="13"> <td style="">13</td> <td style="">Item 13</td> <td style="">$13</td> </tr><tr data-index="14"> <td style="">14</td> <td style="">Item 14</td> <td style="">$14</td> </tr><tr data-index="15"> <td style="">15</td> <td style="">Item 15</td> <td style="">$15</td> </tr><tr data-index="16"> <td style="">16</td> <td style="">Item 16</td> <td style="">$16</td> </tr><tr data-index="17"> <td style="">17</td> <td style="">Item 17</td> <td style="">$17</td> </tr><tr data-index="18"> <td style="">18</td> <td style="">Item 18</td> <td style="">$18</td> </tr><tr data-index="19"> <td style="">19</td> <td style="">Item 19</td> <td style="">$19</td> </tr><tr data-index="20"> <td style="">20</td> <td style="">Item 20</td> <td style="">$20</td> </tr></tbody>
</table>


<!-- jQuery 3 -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.js') }}"></script>
</body>
</html> 