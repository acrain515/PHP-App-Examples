<!DOCTYPE html>
<head>

<style>
  body { font-family:Arial; }
  h2 { padding:20px; }
  table { border-collapse:collapse;border:1px solid #333; }
  th { font-size: 14px;background:#222;color:#fff;padding:3px 5px;text-align:center; }
  td { padding:3px 5px;border-top:1px solid #777;border-bottom:1px solid #777;border-right:1px solid #777; }
  td.label { width: 170px;font-size:13px;padding:3px 4px 3px 8px;font-weight:bold;border-left:1px solid #777;border-right:0;font-size:20px; }
  td.label2 { width: 70px;font-size:13px;padding:3px 4px 3px 8px;font-weight:bold;border-left:1px solid #777;border-right:0; }
  td.label3 { width: 110px;font-size:13px;padding:3px 4px 3px 8px;font-weight:bold;border-left:1px solid #777;border-right:0; }
  input { background:#efefef;text-align:center;padding:2px;border:1px solid #aaa;border-radius:2px;height:30px;font-size:20px; }
  input:focus { border: 1px solid #cc0099;background: #fff;outline: none; }
  textarea { background:#efefef;width:800px;height:90px;resize:none;overflow:hidden;border:1px solid #aaa;border-radius:2px; }
  textarea:focus { border: 1px solid #cc0099;background: #fff;outline: none; }
  #report tr.odd td { background:#fff; }
  #report div.up { background-position:0px 0px;}
  .arrow { cursor:pointer;}
  #report h4 { margin:0;padding:0 4px;font-size:30px;font-weight:bold; }
  #request td.center { text-align:center; }
  input[type="submit"] { margin: 10px;padding:4px 8px;background:#0099cc;color:#fff;font-size:16px;font-weight:bold; }
</style>

</head>
<body>
<div style="width:1200px;margin:0 auto;">

<div style="width:400px;margin:100px auto;">
  <form action="low-utilization-uploaded.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <table style="width:400px;">
            <tr>
              <td class="label"><input type="file" name="file"></td><td><input type="submit" name="btn_submit" value="Upload" /></td>
            </tr>
          </table>
  </div>	
</body>