<?php

require 'lib/dompdf/vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

$html = ' <html>
<head>
<meta charset="UTF-8">
<style>
@page { 
  margin: 0.25in;
}

/* General
-----------------------------------------------------------------------*/
body { 
  background-color: transparent;
  color: black;
  font-family: "verdana", "sans-serif";
  margin: 0px;
  padding-top: 0px;
  font-size: 1em;
}

/* Notes
-----------------------------------------------------------------------*/
.note_form { 
  display: none;
}


/* Page
-----------------------------------------------------------------------*/
.page {
  background-color: white;
  padding: 20px;
  font-size: 0.7em;
  margin-bottom: 15px;
  margin-right: 5px;
}


/* Sales-agreement specific
-----------------------------------------------------------------------*/
table.sa_signature_box { 
  margin: 2em auto 2em auto;
}

table.sa_signature_box tr td { 
  padding-top: 1.5em;
  vertical-align: top;
  white-space: nowrap;
}

.special_conditions { 
  font-style: italic;
  margin-left: 2em; 
  white-space: pre;
  font-weight: bold;
}

.page h2 { 
  text-align: left;
}

@media print { 
  p { margin: 2px; }
}

/* Content
-----------------------------------------------------------------------*/
#content {
  padding: 0.2em 1% 0.2em 1%;
  min-height: 15em;
}


/* Change order specific
-----------------------------------------------------------------------*/
table.change_order_items { 
  font-size: 8pt;
  width: 100%;
  border-collapse: collapse;
  margin-top: 2em;
  margin-bottom: 2em;
}

table.change_order_items>tbody { 
  border: 1px solid black;
}

table.change_order_items>tbody>tr>th { 
  border-bottom: 1px solid black;
}

table.change_order_items>tbody>tr>td { 
  border-right: 1px solid black;
  padding: 0.5em;
}

td.change_order_total_col { 
  padding-right: 4pt;
  text-align: right;
}

td.change_order_unit_col { 
  padding-left: 2pt;
  text-align: left;
}
</style>
</head>


<body>

  <div id="body">
    <div id="content">      
      <div class="page" style="font-size: 7pt">
        <table class="change_order_items">
          <tbody>
            <tr class="even_row">
              <td rowspan="2">Font family</td>
              <td rowspan="2">Variants</td>
              <td colspan="6">File versions</td>
            </tr>
            <tr class="even_row">
              <td>TTF</td>
              <td>AFM</td>
              <td>AFM cache</td>
              <td>UFM</td>
              <td>UFM cache</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html> ';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

exit(0);
