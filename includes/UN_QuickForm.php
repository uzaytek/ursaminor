<?php

require_once 'HTML/QuickForm.php';

/**
 * Quickform class for ursaminor extends from Pear HTML_Quickform
 *
 */ 
class UN_QuickForm extends HTML_QuickForm {

  /**
   * QuickForm form object, changes default renderer html and js messages
   * 
   * @param string $formName The form name
   * @param string $method The form method
   * @param string $action Form action
   * @param string $target Form target
   * @param array $attr Form attributes
   * @param boolean $track Track form submit if true
   */
  function UN_QuickForm($formName, $method='post', $action='', $target='', $attr=null, $track=true) {
    //formname, method, action, target, attributes, tracksubmit
    parent::HTML_QuickForm($formName, $method, $action, $target, $attr, $track);
    $renderer =& $this->defaultRenderer();
    
    $element_template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element}
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
</tr>';

    $header_template='
<tr>
  <th valign="top" colspan="2">
   {header}
  </th>
</tr>';

    $renderer->setElementTemplate($element_template);
    $renderer->setHeaderTemplate($header_template);
    
    $this->setRequiredNote('<span class="warn"><span class="star">*</span> '._('required fields').'</span>');
    $this->setJsWarnings('Error found!', _('Please correct all errors and try again!'));
    $this->applyFilter('__ALL__', 'trim');    
  }

  /**
   * Export form values
   *
   */ 
  function exportValues() {
    //    return parent::exportValues();
    return UN_Filter(parent::exportValues());    
  }

  /**
   * Checkbox element template
   *
   * @param string $elementID The checkbox element id
   */ 
  function setCheckBoxTemplate($elementID) {
    $renderer =& $this->defaultRenderer();

    $template='
<tr>
  <td valign="top">&nbsp;</td>
    <td valign="top">
    {element}  
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);
  }

  /**
   * Date element template
   *
   * @param string $elementID The date element id
   */ 
  function setDateTemplate($elementID) {
    $renderer =& $this->defaultRenderer();
    
    $template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element} <img id="'.$elementID.'_img" alt="'._('Calendar...').'" title="'._('Calendar...').'" 
src="'.LC_SITE.'includes/js/calendar/img.gif" border="0" style="cursor:pointer;" align="top">
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
<script type="text/javascript">
<!--
Calendar.setup({
inputField     :    \''.$elementID.'\',     // id of the input field
ifFormat       :    \'%d/%m/%Y %H:%M:%S\',  // format of the input field
button         :    \''.$elementID.'_img\', // trigger for the calendar (button ID)
singleClick    :    true,
showsTime      :    true
});
-->
</script>
    </td>
</tr>';

  
    $renderer->setElementTemplate($template, $elementID);

  }

  /**
   * Wrap parameter in the tr html
   *
   * @param string $val Paratmeter value
   * @param integer $colspan Colspan count
   * @return string The value in the tr column
   */ 
  function withTR($val, $colspan=2) {
    return '
<tr>
    <td valign="top" colspan="'.$colspan.'">
    '.$val.'
    </td>
</tr>';
  }


  /**
   * Inline element template
   *
   * @param string $elementID The element id
   */ 
  function setInlineTemplate($elementID) {
    $renderer =& $this->defaultRenderer();
    $template='{label} {element}
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->';

    $renderer->setElementTemplate($template, $elementID);
  }

  /**
   * Rich text editor element template
   *
   * @param string $elementID The rte element id
   */ 
  function setRichTextTemplate($elementID) {
    $renderer =& $this->defaultRenderer();


    $template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element}
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
<!-- TinyMCE -->
<script type="text/javascript" src="'.LC_SITE.'assets/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
      elements: "'.$elementID.'",
		theme : "advanced",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true
	});
</script>
<!-- /TinyMCE -->
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);

  }

  /**
   * Colspan element template
   *
   * @param string $elementID The date element id
   * @param boolean $begin if true add tr
   * @param boolean $end if true add /tr
   * @param integer $colspan Colspan count
   */ 
  function setColTemplate($elementID, $begin=false, $end=false, $colspan=0) {
    $renderer =& $this->defaultRenderer();

    $template = ($begin == true) ? '<tr>': '';

    $template .= '
  <td valign="top" '.($colspan > 0 ? 'colspan="'.$colspan.'"' : '').'>
    {label}
    {element}
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
';

    $template .= ($end == true) ? '</tr>': '';

    $renderer->setElementTemplate($template, $elementID);

  }

  /**
   * Up/down select box element template,
   *
   * @param string $elementID The selectbox element id
   * @see javascripts/selectbox.js
   */ 
  function setUpDownSelectTemplate($elementID) {
    $renderer =& $this->defaultRenderer();

    $template='
<tr>
  <td valign="top">
    {label}<br />
    {element}
  </td>
  <td valign="middle">
	<input type="button" class="si" value="&nbsp;'._('Up').'&nbsp;" onClick="moveOptionUp(this.form[\''.$elementID.'[]\'])">
	<br /><br />
	<input type="button" class="si" value="'._('Down').'" onClick="moveOptionDown(this.form[\''.$elementID.'[]\'])">
	</td>
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);

  }

  /**
   * File element template
   *
   * @param string $elementID The file element id
   * @param string $fileName If file exists show view/delete links
   */ 
  function setFileTemplate($elementID, $fileName) {
    $renderer =& $this->defaultRenderer();

    $template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element}<br />';

    if($fileName != '' && file_exists(PT_UPLOAD.$fileName)) {
      $template.='
 <a href="view.php?t=logo&f='.$fileName.'" target="_blank" 
onClick="openWindow(\'view.php?t=logo&f='.$fileName.'\');return false;">VIEW</a>
 <a href="delete.php?t=logo&f='.$fileName.'" target="_blank"
onClick="openWindow(\'delete.php?t=logo&f='.$fileName.'\');return false;">DELETE</a>';
        }

    $template.='
    <!-- BEGIN required --><span class="star">*</span><!-- END required --> 
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);

  }

  /**
   * Add a note in the element bottom
   *
   * @param string $elementID The element id
   * @param string $subnote The note
   * @param booleand $bbr if true add note below in the element
   */ 
  function setAddNoteTemplate($elementID, $subnote, $bbr=false) {
    $renderer =& $this->defaultRenderer();

    $template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element} '.(($bbr) ? '<br />' : '') . $subnote.'
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);

  }


  /**
   * Auto complete ajax template (scriptaculous)
   *
   * @param string $elementID The auto complete element id
   * @param string $acID Element css id
   * @param array $acJsArray Javascript Array for autocomplete
   */ 
  function setAutoComplete($elementID, $acID, $acJsArray) {
    $renderer =& $this->defaultRenderer();

    $template='
<tr>
  <td valign="top">
    {label}
  </td>
    <td valign="top">
    {element} <br />'._('Please seperate tags by comma').'
    <!-- BEGIN required --><span class="star">*</span><!-- END required -->
    <!-- BEGIN error --><br /><span style="color: red">{error}</span><!-- END error -->
<div id="'.$acID.'Update" style="display:none;border:1px solid black;background-color:white;height:50px;overflow:auto;"></div>

<script type="text/javascript" language="javascript" charset="utf-8">
// <![CDATA[
  new Autocompleter.Local(\''.$acID.'\',\''.$acID.'Update\', '.$acJsArray.
      ', { tokens: new Array(\',\',\'\n\'), fullSearch: true, partialSearch: true });
// ]]>
</script>
    </td>
</tr>';

    $renderer->setElementTemplate($template, $elementID);
  }

  /**
   * Reset form values to defauts
   * 
   * Note: May be we could use parent::setDefaults function, but it isn't worked
   * after validate or after exportvalues functions
   *
   */
  function resetDefaults($defaults) {
    if (is_array($defaults)) {
      foreach($defaults as $name=>$value) {
        if ($this->elementExists($name)) {
          $element =& $this->getElement($name);
   	    if (!PEAR::isError($element)) {
	         $element->setValue($value);
          }
        }// if exists
      }// end foreach
    } // if is array
  }
}

?>
