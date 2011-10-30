/*##############################################################################

  AJAX Data Grid
  
  An AJAX enabled datagrid with pagewise scrolling, column sorting, and in-place 
  editing of data cells with textbox, textarea, select, or checkbox controls.
  
  Written by: Hugo Weijes 28 DEC 2006 (fx122@yahoo.com)
  
  License: MIT (http://www.opensource.org/licenses/mit-license.html)

  This file is an extended version of TableEditor written by Andrew Sullivan
  http://www.phpclasses.org/browse/package/3104.html - acsulli@gmail.com
  
================================================================================
Copyright (c) 2006, Hugo Weijes

Permission is hereby granted, free of charge, to any person obtaining a copy of 
this software and associated documentation files (the "Software"), to deal in 
the Software without restriction, including without limitation the rights to 
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
the Software, and to permit persons to whom the Software is furnished to do so, 
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS 
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR 
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER 
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
##############################################################################*/
function dataGrid(jsClass,requestFile)
{
  this.m_columns = new Array(); //load the column definitions here
  
  this.m_requestFile = requestFile; //load the ajax request file name here
  this.m_jsClass = jsClass; //load the name of the dataGrid class instance here
  
  //current 'in edit' variables
    this.m_rowid = ""; //current edit cell rowid 
    this.m_colid = ""; //current edit cell colid
    this.m_editid = ""; //current edit cell htmlid (or blank if none)
    this.m_oldval = ""; //saved old value for current edit cell
  
  this.m_move_ajax = "ok"; //sack used for row position moves and sorting
  this.m_move_pos = 1;
  this.m_move_sortcol = "";
  this.m_move_sortdesc=false;
  
    this.m_ajax = new Array(); //sacks used for cell updates
  this.m_busyArr = new Array(); //the html ids of the busy elements
  this.m_busyCnt = 0; //number of busy elements
  
  //add id to busy items, returns true on success false if item is currently busy
  this.busyAdd = function(htmlid)
  {
    this.busyShowStatus();
    if(this.m_busyArr[htmlid]) return false;
    this.m_busyArr[htmlid]=true;
    this.m_busyCnt++;
    this.busyShowStatus();
    return true;
  }
  //get busy status
  this.busyGet = function(htmlid)
  {
    if(true != this.m_busyArr[htmlid]) return false; else return true;
  }
  //clear id as busy, returs true if item was busy
  this.busyRemove = function(htmlid)
  {
    this.busyShowStatus();
    if(true != this.m_busyArr[htmlid]) return false;
    delete this.m_busyArr[htmlid];
    this.m_busyCnt--;
    this.busyShowStatus();
    return true;
  }
  //show current item busy message
  this.busyShowMsg = function()
  {
    alert("Update pending for this item, please wait ...");
  }
  //show busy status
  this.busyShowStatus = function()
  {
    if(this.m_busyCnt==0) 
      defaultStatus="";
    else
    { 
      var msg = "";
      for(var k in this.m_busyArr)
      {
        msg += k + " ";
      }
      defaultStatus = this.m_jsClass + " " + this.m_busyCnt + " update(s) pending ... " + msg;
    }
  }

  this.msgUpdateFailed = function(a)
  {
    alert("An error occurred saving your data\r\n\r\n" + a.response + "\r\n\r\n" +"old=" + a.edit_oldval + " new=" + a.getVar("new") + " col=" + a.getVar("colid") + " row=" + a.getVar("rowid"));
  }
}

//html escape " ' and <
function dg_esc(s)
{
  return s.replace(/</g,"&lt;").replace(/'/g,"&#039;").replace(/"/g,"&quot;");
}

//======================================================================
//event handlers (can not be inside of a class)
//======================================================================

//event handler checkbox changed
function dg_checkChange(me, rowid, colid, htmlid)
{
  var n = document.getElementById(htmlid);
  if(!me.busyAdd(htmlid)) 
  {
    n.checked = !n.checked;
    me.busyShowMsg();
    return;
  }
                          
  var index = me.m_ajax.length;      
  var a = new sack();
  me.m_ajax[index]=a;
  a.requestFile = me.m_requestFile;
  
  a.setVar("ajax", "updcell");
  a.setVar("tbl", me.m_jsClass);
  a.setVar("rowid", rowid);
  a.setVar("colid", colid);
  a.setVar("new", (n.checked?1:0));
  a.setVar("old", (n.checked?0:1));
    
  a.edit_htmlid = htmlid;
  a.edit_oldval = !n.checked;
  
  a.onCompletion = function(){ dg_checkChangeSaved(me,index); };
  a.runAJAX()
}

//event handler ajax response on checkbox changed
function dg_checkChangeSaved(me,index)
{
  var a = me.m_ajax[index];
    if(a.response != "") 
  {
        me.msgUpdateFailed(a);
    defaultStatus = "";
        var elem = document.getElementById(a.edit_htmlid);
    elem.checked = a.edit_oldval; 
    }
  me.busyRemove(a.edit_htmlid);
  me.m_ajax[index]="";
}




//event handler edit table cell (shows appropiate edit box)   
function dg_editCell(me, rowid, colid, htmlid) 
{
  if (me.m_editid == htmlid) return;
  
  if (me.m_editid != "") 
  {
   document.getElementById(me.m_editid).innerHTML = me.m_oldval;
    me.busyRemove(me.m_editid);
  }

  if(me.busyGet(htmlid)) 
  {
    me.busyShowMsg();
    return;
  }

  me.m_editid = htmlid;
  me.m_rowid = rowid;
  me.m_colid = colid;
    
  var cell = document.getElementById(htmlid);
  me.m_oldval = cell.innerHTML;

  //alert(cid);
  //alert(cell.width);
  
  var editContent;
  if(me.m_columns[colid]==undefined)
  {
    alert("undefined column: " + colid); //XXX
  }
  else
  {
    var onblur="id='editCell' onblur='dg_onBlur(" + me.m_jsClass + ",this);'";
    var onblur2="id='editCell' onblur='dg_onSelectkeyBlur(" + me.m_jsClass + ",this);'";

    var coldef = me.m_columns[colid];
    var opt;
    //var selObj;
    //var i;
    switch(coldef["coltype"]) 
    {
    //======================================================================
    //SELECT Columns        
    //======================================================================
    case 'select':
          editContent = "<select " + onblur + ">";
      if(coldef.selectvalues!=undefined) for(opt in coldef.selectvalues)
      {
        editContent += '<option value="' + dg_esc(coldef.selectvalues[opt]) + '"';
        if(dg_esc(coldef.selectvalues[opt]) == dg_esc(me.m_oldval)) editContent += " selected"
        editContent += ">" + coldef.selectvalues[opt] + "</option>";
      }  
      editContent += "</select>";        
          cell.innerHTML = editContent;
/*      
      selObj = document.getElementById('editCell');
          if (selObj.options!=null) 
      {
            for(i=0; i<selObj.options.length; i++) 
        {
          //alert(selObj.options[i].text);
          if(dg_esc(selObj.options[i].text) == me.m_oldval) 
          {
            selObj.options[i].selected=true;
            //alert("selected");
          }
        }
      }
*/
      break;

    //======================================================================
    //SELECTKEY Columns        
    //======================================================================
    case 'selectkey':
      me.m_oldKey = document.getElementById(htmlid+'.h').value;
          editContent = "<select " + onblur2 + ">";
      if(coldef.selectvalues!=undefined) for(opt in coldef.selectvalues)
      {
        editContent += "<option value='" + opt + "'";
        if(opt == me.m_oldKey) editContent += " selected"
        editContent += ">" + coldef.selectvalues[opt] + "</option>";
      }  
      editContent += "</select>";        
          cell.innerHTML = editContent;
      break;
            
    //======================================================================
    //TEXTAREA Columns        
    //======================================================================
    case 'textarea':        
          editContent = "<textarea " + onblur + " style='" + coldef["style"] +"'>" + dg_esc(me.m_oldval) + "</textarea>";
      cell.innerHTML = editContent;
      break;

    //======================================================================
    //TEXT Columns   
    //======================================================================
    case 'text':    
          editContent = "<input " + onblur + " type='text' size='15' value='" + dg_esc(me.m_oldval) + "'>";
          cell.innerHTML = editContent;
      break;

    //======================================================================
    //READONLY Columns (default)      
    //======================================================================
    default:
      alert("read only!");
      //defaultStatus = "read only";
      return;
    }//switch
    document.getElementById('editCell').focus();
  }
}

//event handler edit box save
function dg_onBlur(me,n) 
{
  var newval = n.value;
        
  //alert(newval + "\n" + me.m_oldval);
  //defaultStatus = "Saving Change: new=" + newval + " col=" + me.m_colid + " row=" + me.m_rowid;
  
  if (newval == me.m_oldval) 
  {
    document.getElementById(me.m_editid).innerHTML = "";
    document.getElementById(me.m_editid).innerHTML = me.m_oldval;
  } 
  else
  { 
      me.busyAdd(me.m_editid);
    document.getElementById(me.m_editid).innerHTML = dg_esc(newval);
      
    var index = me.m_ajax.length;      
      var a = new sack();
    me.m_ajax[index]=a;
      a.requestFile = me.m_requestFile;
      
    a.setVar("ajax", "updcell");
    a.setVar("tbl", me.m_jsClass);
      a.setVar("rowid", me.m_rowid);
      a.setVar("colid", me.m_colid);
      a.setVar("new", newval);
      a.setVar("old", me.m_oldval);
        
      a.edit_htmlid = me.m_editid;
    a.edit_oldval = me.m_oldval;
      
      a.onCompletion = function(){ dg_onSaved(me,index); };
      a.runAJAX();
  }
  me.m_oldval = "";
  me.m_editid = "";
  me.m_rowid = "";
  me.m_colid = "";
}


//event handler ajax response on edit box save  
function dg_onSaved(me,index) 
{
  var a = me.m_ajax[index];                
  var htmlid = a.edit_htmlid; 
  if (htmlid != "") 
  {
      if (a.response != "") 
    {
          me.msgUpdateFailed(a);
          //document.getElementById(htmlid).innerHTML = a.getVar("old"); //does not work because "old" is escaped...
          document.getElementById(htmlid).innerHTML = a.edit_oldval;
      }
    me.busyRemove(a.edit_htmlid);
      me.m_ajax[index] = "";
  }
}



//event handler edit box save
function dg_onSelectkeyBlur(me,n) 
{
  var newkey = n.value;
        
  //alert("dg_saveCellKey newkey=" + newkey + " oldkey=" + me.m_oldKey);

  if (newkey == me.m_oldKey) 
  {
    document.getElementById(me.m_editid).innerHTML = "";
    document.getElementById(me.m_editid).innerHTML = me.m_oldval;
  } 
  else
  { 
      me.busyAdd(me.m_editid);
    document.getElementById(me.m_editid).innerHTML = '<input type="hidden" id="' + me.m_editid + '.h" value="' + dg_esc(newkey) + '">' + dg_esc(me.m_columns[me.m_colid].selectvalues[newkey]);
      
    var index = me.m_ajax.length;      
      var a = new sack();
    me.m_ajax[index]=a;
      a.requestFile = me.m_requestFile;
      
    a.setVar("ajax", "updcell");
    a.setVar("tbl", me.m_jsClass);
      a.setVar("rowid", me.m_rowid);
      a.setVar("colid", me.m_colid);
      a.setVar("new", newkey);
      a.setVar("old", me.m_oldKey);
        
      a.edit_htmlid = me.m_editid;
    a.edit_oldval = me.m_oldval;
      
      a.onCompletion = function(){ dg_onSaved(me,index); };
      a.runAJAX();
    me.m_ajax[index]=a;
  }
  me.m_oldKey = "";
  me.m_oldval = "";
  me.m_editid = "";
  me.m_rowid = "";
  me.m_colid = "";
}

function dg_move(me,pos)
{
  dg_navigate(me,pos,me.m_move_sortcol);
}

function dg_onHeadClick(me,sortcol)
{
  if(sortcol == me.m_move_sortcol) 
    me.m_move_sortdesc=!me.m_move_sortdesc;
  else
    me.m_move_sortdesc=false;
  dg_navigate(me,me.m_move_pos,sortcol);
}

function dg_navigate(me,pos,sortcol)
{
  //exit if busy moving
  if(me.m_move_ajax!="ok") return;
  
  //save navigation info
  me.m_move_pos=pos;
  me.m_move_sortcol=sortcol;
  
  //display loading... 
  var navElem = document.getElementById(me.m_jsClass +".navbusy"); 
  if(navElem!=undefined) navElem.innerHTML="Loading..."
    
  //create ajax request
  var a = new sack();
  me.m_move_ajax=a;
  a.requestFile = me.m_requestFile;
      
  a.setVar("ajax", "nav");
  a.setVar("tbl", me.m_jsClass);
  a.setVar("pos", pos);
  a.setVar("sortcol", sortcol);
  a.setVar("sortdesc", (me.m_move_sortdesc?1:0));
      
  a.onCompletion = function(){ dg_navigate2(me); };
  a.runAJAX();
}

function dg_navigate2(me)
{
  //alert("dg_onHeadClick2 tbl=" + me.m_jsClass + " response=" + dg_move_ajax.response);
  
  elem = document.getElementById(me.m_jsClass +".navbusy"); 
  if(elem!=undefined) elem.innerHTML='';
  
  var data = me.m_move_ajax.response;
  
  //update table data
    //CHANGE THM: replace '.' with '-'
  if(data != "") document.getElementById(me.m_jsClass + "-span").innerHTML = data;
  
  //make move available again
  me.m_move_ajax="ok";
}