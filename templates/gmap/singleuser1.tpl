    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
    {$google_map_header}
    {$google_map_js}
    <!-- necessary for google maps polyline drawing in IE -->
    <style type="text/css">
      v\:* {ldelim}
        behavior:url(#default#VML);
     {rdelim}
    </style>
    </head>
    <body onload="onLoad()">
    <table>
      <tr>
        <td>{$google_map}</td>

<!--        <td>{$google_map_sidebar}</td>-->
      </tr>
    </table>
    </body>
    </html>