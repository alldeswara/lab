<?php $this->load->view('top');?>
<!--<input type="text" id="dd" value="1">-->
<script type="text/javascript">
  function updated(id)
  {
      setInterval( function()
      {
          var va=$('#dd').val();
          if(va==1){
            $('#dd').val('2');
          }else{
            $('#dd').val('1');
          }
      }, 1000 )
  };

  //  Check for updates every 10 seconds
  $( document ).ready( checkUpdates );
</script>
         <div class="row" id="frm-list">
         <form role='form' method="POST" action="<?php echo base_url()?>nilai/insert_nilai">
              <input type="hidden" name="id_kelas" value="<?php echo $id_kelas;?>">
              <input type="hidden" name="id_mata_pelajaran" value="<?php echo $id_mata_pelajaran;?>">
              <div class="col-lg-8">
                <div class="box ">
                  <header class="dark">
                    <div class="icons">
                      <i class="fa fa-table"></i>
                    </div>
                    <h5>Info Status</h5>

                    <!-- .toolbar -->
                    <div class="toolbar">
                      <nav style="padding: 8px;">
                        <!--<a href="javascript:;" class="btn btn-default btn-xs collapse-box">
                          <i class="fa fa-minus"></i>
                        </a> 
                        <a href="javascript:;" class="btn btn-default btn-xs full-box">
                          <i class="fa fa-expand"></i>
                        </a> 
                        <a href="javascript:;" class="btn btn-danger btn-xs close-box">
                          <i class="fa fa-times"></i>
                        </a>  
                        -->
                        <a href="<?php echo base_url()?>info_sms/index/" id="back" class="btn btn-success btn-xs">
                          <i class="glyphicon glyphicon-book"></i> Back
                        </a>
                      </nav>
                    </div><!-- /.toolbar -->
                  </header>
                  <div class="body">
                  <?php echo $this->session->flashdata('msg');?>
                    <table  class="dt_table table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                          <th>NIS</th>
                          <th>Nama Siswa</th>
                          <th>Nilai</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=0;foreach($list as $data){?>
                        <tr>
                          <td><?php echo $data->nis;?></td>
                          <td><?php echo $data->nama_siswa;?></td>
                          <td><?php echo $data->nilai;?></td>
                          <td><?php if(!empty($data->ID)){ echo $data->Status;}else{?><a href='<?php echo base_url();?>info_sms/reSend/<?php echo $data->ID_sentitems;?>/<?php echo $data->id_nilai_dtl;?>' class='btn btn-warning'> Kirim Ulang </a><?php } ?></td>

                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


                  
                </div>
              </div>
            </form>
            </div>



<?php $this->load->view('footer');?>