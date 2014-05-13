<!DOCTYPE html>
<html>
<head>
<?
          
     error_reporting(0);
     
if($_POST['resource']=='Basketball'){$r='Courts';}
if($_POST['resource']=='Tennis'){$r='Courts';}
if($_POST['resource']=='Swimming'){$r='Lanes';}
if($_POST['resource']=='Netball'){$r='Courts';}
if($_POST['resource']=='Tennis'){$r='Courts';}
if($_POST['resource']=='Table Tennis'){$r='Courts';}
if($_POST['resource']=='Volleyball'){$r='Courts';}


if($_POST['resource']=='Aqua Classes'){$r='Spaces';}
if($_POST['resource']=='Gymnastics'){$r='Spaces';}
if($_POST['resource']=='Yoga'){$r='Spaces';}
if($_POST['resource']=='WSC Programme'){$r='Spaces';}
if($_POST['resource']=='Museum Programme'){$r='Spaces';}
if($_POST['resource']=='MICE Events'){$r='Spaces';}
if($_POST['resource']==''){$r='Lanes';}



?>
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='lib/jquery.min.js'></script>
<script src='lib/jquery-ui.custom.min.js'></script>
<script src='fullcalendar/fullcalendar.min.js'></script>

<script>

	$(document).ready(function() {
	    
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({   
                                                
    slotMinutes:'60',
   timeFormat:  'HH:mm { - HH:mm}',
           defaultView: 'agendaWeek', 
                    allDaySlot:false, 
                   disableResizing: true,
                     minTime:'8:00',
                  maxTime:'21:00',
                    
                    events: 'json-resource-events.php?r=<?php echo $r; ?>',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'agendaDay,agendaWeek,resourceDay' 
                            
			},  
      
      eventClick: function(calEvent, jsEvent, view) {
        window.location = "http://www.domain.com?start=" + calEvent.start;

    },  
      firstDay:1, 
       
       resources: 'json-resources.php',
			editable: true,
      alldayslot: false 
		 
		});
    
    $('#datepicker').datepicker({
        inline: true,
        onSelect: function(dateText, inst) {
            var d = new Date(dateText);
            $('#calendar').fullCalendar('gotoDate', d);
        }
    }); 
} );
 $('#datepicker').datepicker({
        inline: true,
        onSelect: function(dateText, inst) {
            var d = new Date(dateText);
            $('#calendar').fullCalendar('gotoDate', d);
        }
    }); 
 
</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<body>
    
   <center>
      
    <table>
    <tr><Td style="font-size:22px;color:#002d62;">
    
    <form action=""  METHOD=POST> Please choose which activity you wish to book 
    
       <select style="font-size:24px;" name=resource onchange="this.form.submit()">
     

     <option   <? if($_POST['resource']=='Basketball'){echo"selected=selected";} ?>>Venue Type</option> 
  
      
   </select>
    <select style="font-size:24px;" name=resource onchange="this.form.submit()">
     

     <option   <? if($_POST['resource']=='Basketball'){echo"selected=selected";} ?>>Basketball</option> 
     <option   <? if($_POST['resource']=='Swimming' || $_POST['resource']==''){echo"selected=selected";} ?>>Swimming</option> 
      <option   <? if($_POST['resource']=='Netball'){echo"selected=selected";} ?>>Netball</option>
      <option   <? if($_POST['resource']=='Tennis'){echo"selected=selected";} ?>>Tennis</option>      
      <option   <? if($_POST['resource']=='Table Tennis'){echo"selected=selected";} ?>>Table Tennis</option>      
      <option   <? if($_POST['resource']=='Volleyball'){echo"selected=selected";} ?>>Volleyball</option>  
      <option></option>  
 
      
   </select>
      
     </form> 
      
      <br /><Br /></td></tr>
    <tr> <Td>
<div id='calendar'></div>
 <div id="datepicker"></div>

</td></tr></table>

 
</body>

 
</html> 
                    