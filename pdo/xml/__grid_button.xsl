<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="yes"/>
<xsl:decimal-format name="euro" decimal-separator="," grouping-separator="."/>
<xsl:template match="/">
<html>
 <head>
  <meta http-equiv="content-type" content="text/xhtml; charset=ISO-8859-1"/>
   <link href="grid.css" rel="stylesheet" type="text/css"/> 
    <script type="text/javascript" src="grid.js">
    </script>
    <xsl:for-each select="root/title">
   <title><xsl:value-of select="."/></title>
   </xsl:for-each>
  </head>
 <body>
 <div id="grid" class="grid">
 <table width="100%">
  <tr>
	<xsl:for-each select="root/buton">
   	<td width="60"><button type="button" onclick="return butonaction(this);">
  	 <xsl:attribute name="value">
  	 <xsl:value-of select="burl"/>
  	 </xsl:attribute> 
  	 <xsl:attribute name="class">
  	 <xsl:value-of select="bname"/>
  	 </xsl:attribute>
  	 <xsl:value-of select="bname"/>
  	 </button></td>
	</xsl:for-each>
 <td></td>
 </tr>
</table>
<div class="ajaxgrid" id="ajaxgrid">
<table width="100%" border="1" align="center">
  <thead>
    <tr>
      <xsl:for-each select="root/colum">
        <xsl:for-each select="descendant::*">
          <th><xsl:value-of select="."/></th>
        </xsl:for-each>
      </xsl:for-each>
    </tr>		
  </thead>
<tbody>
  <xsl:for-each select="root/data">
    <tr onclick="seleciona(this)">
     <xsl:attribute name="id">
     <xsl:value-of select="id"/>
    </xsl:attribute>     
       <xsl:for-each select="values">
        <xsl:for-each select="descendant::*">
		   <td><xsl:value-of select="."/></td>
		  </xsl:for-each>
		 </xsl:for-each>
    </tr>
  </xsl:for-each>		
</tbody>
  <tfoot>
  </tfoot>
</table>
</div>
<div id="filters" class="filters">
  <form action="?Page=0" name="filter" class="form filter" method="get" >
   <table>
    <tr>
     <td>
      <select name="filter">
       <xsl:for-each select="root/filters">
        <option>
       <xsl:attribute name="value">
  	    <xsl:value-of select="filtervalue"/>
  	    </xsl:attribute> 
       <xsl:value-of select="filtername"/>
        </option>
       </xsl:for-each>
      </select>
    </td>
   <td>
  <input type="text" size="30" name="filtervalue" />
 </td>
<td>
 <button type="button" name="localizar" onClick="submit();" class="localizar">Enviar</button>
</td>
 </tr>
  </table>
 </form>
</div>
<table id="rodape" class="rodape">
     <tr><td>
     <xsl:for-each select="root/page/numpage">
     <xsl:if test="beforepage &gt; 0">
     <td><a>
     <xsl:attribute name="href">
     <![CDATA[?Page=]]>
     <xsl:value-of select="beforepage"/>
     <![CDATA[&filter=]]>
     <xsl:value-of select="filter"/>
     <![CDATA[&filtervalue=]]>
     <xsl:value-of select="filtervalue"/>
     </xsl:attribute> 
     <xsl:value-of select="beforepage"/>
     </a></td>
     </xsl:if>
     <xsl:if test="currentpage &gt; 0">
     <td><xsl:value-of select="currentpage"/></td>
     </xsl:if>
     <xsl:if test="afterpage &gt; 0">
     <td>   
     <a>
     <xsl:attribute name="href">
     <![CDATA[?Page=]]>
     <xsl:value-of select="afterpage"/>
     <![CDATA[&filter=]]>
     <xsl:value-of select="filter"/>
     <![CDATA[&filtervalue=]]>
     <xsl:value-of select="filtervalue"/>
     </xsl:attribute>
     <xsl:value-of select="afterpage"/>
     </a></td>
     </xsl:if>
     <td> 
     <xsl:value-of select="numberrows"/> 
     </td>
     </xsl:for-each>
     <td>Registros</td>
     </td></tr>
     </table>
</div>
	</body>
  </html>	 
 </xsl:template>
</xsl:stylesheet>
