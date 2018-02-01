<?php

/*
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comTo change this template, choose Tools | Templates
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comand open the template in the editor.
 */
?>
                <table class="table table-condensed table-bordered no-margin">
                    <thead>
                        <tr>
                            <th>Information</th>
                            <th style="text-align: right;">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="success">
                            <td><b>বিক্রয় হয়েছে</b></td>
                            <td style="text-align: right;">
                                <?php 
                                echo $this->lang->line('BDT_Currency');
                                if($paidsales != NULL) {
                                    echo number_format($paidsales, 2);
                                } else { 
                                    echo '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="info">
                            <td><b>বাকি রয়েছে</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($dueinvcs != FALSE) { 
                                    echo number_format($dueinvcs, 2);//number_format($duesales, 2);
                                } else { 
                                    echo '0.00';
                                } 
                                ?>
                            </td>
                        </tr>
                        <tr class="success">
                            <td><b>কার্ড এর মাদ্ধ্যমে</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($cardsales != NULL) {
                                    echo number_format($cardsales, 2);
                                } else { 
                                    echo '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="success">
                            <td><b>বিনামূল্যে</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($zerosales != NULL) {
                                    echo number_format($zerosales, 2);
                                } else { 
                                    echo '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="error" colspan="2" style="height: 17px;"></td>
                        </tr>
                        <tr class="warning">
                            <td><b>ক্যাশ কালেশন</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($cashin != NULL ) { 
                                    echo number_format($cashin, 2);
                                } else { 
                                    echo '0.00';
                                } 
                                ?>
                            </td>
                        </tr>
                        <tr class="error">
                            <td><b>ক্যাশ বহির্গমন</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($cashout != NULL ) { 
                                    echo number_format(abs($cashout), 2);
                                } else { 
                                    echo '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="error">
                            <td><b>ক্যাশ মযুত</b></td>
                            <td style="text-align: right;">
                                <?php
                                echo $this->lang->line('BDT_Currency');
                                if($cashbalance != NULL ) { 
                                    echo number_format(abs($cashbalance), 2);
                                } else { 
                                    echo '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
