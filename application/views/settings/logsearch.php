 <?if($logs!=FALSE){foreach ($logs->result() as $log) {?>
                      <tr>
                       <td>
                          <?php echo $log->date; ?>
                        </td> 
                        <td>
                          <?php echo $log->time; ?>
                        </td>
                        
                        <td class="hidden-phone">
                         <?php echo $log->user; ?>
                        </td>
                        <td class="hidden-phone">
                        <?php echo $log->dept; ?>
                        </td>
                        
                        <td class="hidden-phone">
                          <?php echo $log->ip; ?>
                        </td>
                        
                      </tr>
                        <?php }}?>
