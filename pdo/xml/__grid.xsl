<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="yes"/>
<xsl:decimal-format name="euro" decimal-separator="," grouping-separator="."/>
<xsl:template match="/">
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
 </xsl:template>
</xsl:stylesheet>
