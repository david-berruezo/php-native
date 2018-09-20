<html>
<head>
<title>Example Portal Page</title>
</head>
<table width="100%" border="1">
<tr>
  <th width="15%">Paul's Blog</th>
  <th width="70%">Yahoo! Technology</th>
  <th width="15%">Chris's Blog</th>
</tr>
<tr valign="top">
  <td><?php printWidget(3, "http://www.preinheimer.com/rss.php?version=2.0"); ?></td>
  <td><?php printWidget(7, "http://rss.news.yahoo.com/rss/software"); ?></td>
  <td><?php printWidget(3, "http://shiflett.org/rss"); ?></td>
</tr>
</table>
</body>
</html>
