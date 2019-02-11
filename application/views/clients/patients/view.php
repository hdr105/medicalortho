
           
           
<div class="modal-body clearfix">
    
     
       
      


    
                <?php 
               
               $pdf_files = explode(",",$patient_info->pdf_file);

               foreach ($pdf_files as $pdf_file) 
               {
                 $file = base_url("files/patient/").$pdf_file;
                   ?>
                  
                   <a href="<?php echo $file; ?>" download><button class="btn btn-primary btn-sm " type="submit"><i class="fa fa-download"></i><?php echo lang('download_file'); ?></button></a>
               
                   <?php
                     
               }
                
             
            ?>
           




         

     
            


        
      

       
    

        

</div>



