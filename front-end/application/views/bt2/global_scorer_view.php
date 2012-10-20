<style type="text/css"> 
    .ui-header .ui-title { overflow: visible !important;  white-space: nowrap !important; margin: .6em 40% .8em 20%; }
    #one-column-emphasis {
        border-collapse: collapse;
        font-family: "Lucida Sans Unicode","Lucida Grande",Sans-Serif;
        font-size: 12px;
        margin: 5px 0;
        text-align: left;
        width: 100%;
    }
    #one-column-emphasis th {
        color: #003399;
        font-size: 14px;
        font-weight: normal;
        padding: 12px 10px;
        font-weight: bold;
    }
    #one-column-emphasis td {
        border-top: 1px solid #6678B1;
        color: #666699;
        padding: 10px 10px;
    }
</style>
<div data-role="page"  >

    <div data-role="header" data-position="fixed" >
        <!-- <a href="index.html" data-icon="gear" class="ui-btn-right">Options</a> -->
        <span class="ui-title" >Global Brain Tuner Scorer</span>
    </div><!-- /header -->

    <div data-role="content"  >
        <table id="one-column-emphasis" > 
            <caption></caption> 
            <thead> 
                <tr> 
                    <th scope="col" style="width: 150px">Name</th>  
                    <th scope="col">Device</th>
                    <th scope="col">Finish Time</th>  
                    <th scope="col">Date</th>
                </tr> 
            </thead> 
            <tfoot> 
                <tr> 
                    <td colspan="5"></td> 
                </tr> 
            </tfoot> 
            <tbody> 
                <?php foreach ($scorers as $scorer) { ?>
                    <tr > 
                        <td scope="row" style="width: 40%">
                            <div>
                                <img style="width:24px;height:24px;vertical-align:middle" src="http://greengarstudios.com/bt2/common-assets/images/flags/32/<?php echo strtolower($scorer->country_code); ?>.png" alt="<?php echo strtolower($scorer->country_code); ?>" />
                                <span style="margin: 1px 5px;"><?php echo $scorer->name; ?></span>							
                            </div>							
                        </td> 
                        <td><?php echo $scorer->device == '' ? 'iPhone' : $scorer->device; ?></td> 
                        <td><?php echo $scorer->finish_time; ?></td> 
                        <td><?php echo date('d,M,Y', $scorer->timestamp); ?></td> 
                    </tr> 
                <?php } ?>
            </tbody> 
        </table> 
    </div><!-- /content -->

    <div data-role="footer" data-position="fixed" >
        <h4>© 2012 Greengar Studios</h4>
    </div><!-- /footer -->

</div><!-- /page -->