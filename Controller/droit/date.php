
<?php
date_default_timezone_set('Africa/Douala');
/*/////////////////////LA FONCTION TIME DE CYRIAS LE PROGRAMMEUR. LE PLUS GRAND DE TOUS LES TEMPS//////////////////////////////

  'an(s)' => 31557600, 'moi' => 2629800, 'semaine' => 604800, 'jour' => 86400, 'heure' => 3600, 'min' => 60, 'sec' => 1
     $entiere = intval($cyc);  partie entiere
    $decimale = $cyc - $entiere;   partie decimale  
*/

/*$time1 = time() - $date_pub;*/
/*$time = time();
$date1 = date('d/m/Y H:i:s', $time1);
$date = date('d/m/Y H:i:s', time());

echo "$time => $date<br><br> $time1 => $date1<br><br><br><br>";*/

$temps = $date_pub - time();

if (time() > $date_pub) {
  echo " <h3 style='color:red'><b>VOTRE LICENCE EST EXPIRE</b></h3>";
}

  if ($temps >= 31557600) 
  {
    $periode = $temps / 31557600;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

       if ($periode > 1) 
       {
            if ($entiere == 1) 
            {
            // echo "il ya plus de $entiere an";
            }
            else
            {
             //echo "il ya plus de $entiere ans";
            }
        }

       else
       {
        //echo "il ya $entiere an";
       }
  } 

/*/////////////////////////////////////// CYC POUR LES MOIS ////////////////////////////////////////*/

    if ($temps <= 31557599 and $temps >=2629800) 
  {
    $periode = $temps / 2629800;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

       if ($entiere > 3) {
         
               if ($periode > 1) 
       {
        if ($entiere == 1) 
          {
        // echo "il ya $entiere Moi";
          }
            else
          {
        // echo "il ya $entiere Mois";
          }
       }
       else
       {
        //echo "il ya $entiere Moi";
       }

       } 

       else {

            if ($periode > 1) 
               {
                if ($entiere == 1) 
                  {
                 echo "votre licence expire dans $entiere Moi";
                  }
                    else
                  {
                 echo "votre licence expire dans $entiere Mois";
                  }
               }
               else
               {
                echo "votre licence expire dans $entiere Moi";
               }

       }
       
  }

  /*/////////////////////////////////////// CYC POUR LES SEMAINE ////////////////////////////////////////*/

    if ($temps <= 2629800 and $temps >=604800) 
  {
    $periode = $temps / 604800;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

        if ($decimale != 0) 
            {
                $temps_m = $decimale * 604800;

                if ($temps_m % 86400 != 0 )
                  {
                   $periode_jour = $temps_m / 86400;

                   $entiere_jours = intval($periode_jour);

                   if ($entiere <= 1) 
                   {
                                         if ($entiere_jours > 1) 
                    {
                      echo "votre licence expire dans $entiere semaine $entiere_jours jours";
                    }
                      else
                      {
                        if ($entiere_jours == 0) {
                          echo "votre licence expire dans $entiere semaine";
                        }
                        else
                        {
                          echo "votre licence expire dans $entiere semaine $entiere_jours jour";
                        }
                        
                      }
                   } 

                    else 
                    {
                                         if ($entiere_jours > 1) 
                    {
                      echo "votre licence expire dans $entiere semaines $entiere_jours jours";
                    }
                      else
                      {
                        if ($entiere_jours == 0) {
                          echo "votre licence expire dans $entiere semaines";
                        }
                        else
                        {
                          echo "votre licence expire dans $entiere semaines $entiere_jours jour";
                        }
                        
                      }
                    }
                   

                  }
            }
            else
            {
               if ($periode > 1) 
               {
                 echo "votre licence expire dans $entiere semaines";
               }
               else
               {
                echo "votre licence expire dans $entiere semaine";
               }
            }
  }

  /*/////////////////////////////////////// CYC POUR LES JOURS ////////////////////////////////////////*/

    if ($temps <= 604799 and $temps >=86400) 
  {
    $periode = $temps / 86400;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

        if ($decimale != 0) 
            {
                $temps_m = $decimale * 86400;

                if ($temps_m % 3600 != 0 )
                  {
                   $periode_jour = $temps_m / 3600;

                   $entiere_jours = intval($periode_jour);

                   if ($entiere <= 1) 
                   {
                                         if ($entiere_jours > 1) 
                    {
                      echo "votre licence expire dans $entiere Jour $entiere_jours Heures";
                    }
                      else
                      {
                        if ($entiere_jours == 0) {
                          echo "votre licence expire dans $entiere Jour";
                        }
                        else
                        {
                          echo "votre licence expire dans $entiere Jour $entiere_jours Heure";
                        }
                        
                      }
                   } 

                    else 
                    {
                                         if ($entiere_jours > 1) 
                    {
                      echo "votre licence expire dans $entiere Jours $entiere_jours Heures";
                    }
                      else
                      {
                        if ($entiere_jours == 0) {
                          echo "votre licence expire dans $entiere Jours";
                        }
                        else
                        {
                          echo "votre licence expire dans $entiere Jours $entiere_jours Heure";
                        }
                        
                      }
                    }
                   

                  }
            }
            else
            {
               if ($periode > 1) 
               {
                 echo "votre licence expire dans $entiere Jours";
               }
               else
               {
                echo "votre licence expire dans $entiere Jour";
               }
            }
  }

  /*/////////////////////////////////////// CYC POUR LES HEURES ET MINUTES ////////////////////////////////////////*/

    if ($temps <= 86399 and $temps >=3600) 
  {
    $periode = $temps / 3600;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

        if ($decimale != 0) 
            {
                $temps_m = $decimale * 3600;

                if ($temps_m % 60 != 0 )
                  {
                   $periode_minutes = $temps_m / 60;

                   $entiere_minutes = intval($periode_minutes);

                   if ($entiere <= 1) 
                   {
                                         if ($entiere_minutes > 1) 
                    {
                      echo "votre licence expire dans $entiere heure $entiere_minutes Minutes";
                    }
                      else
                      {
                        if ($entiere_minutes == 0) {
                          echo "votre licence expire dans $entiere heure";
                        } else {
                          echo "votre licence expire dans $entiere heure $entiere_minutes Minute";
                        }
                        
                      }
                   } 
                   else 
                   {
                                         if ($entiere_minutes > 1) 
                    {
                      echo "votre licence expire dans $entiere heures $entiere_minutes Minutes";
                    }
                      else
                      {
                        if ($entiere_minutes == 0) {
                          echo "votre licence expire dans $entiere heures";
                        } else {
                          echo "votre licence expire dans $entiere heures $entiere_minutes Minute";
                        }
                      }
                   }
                   
                  }
            }
            else
            {
               if ($periode > 1) 
               {
                 echo "votre licence expire dans $entiere Heures";
               }
               else
               {
                echo "votre licence expire dansa $entiere Heure";
               }
            }
  }

  /*/////////////////////////////////////// CYC POUR LES MINUTE ////////////////////////////////////////*/

    if ($temps <= 3599 and $temps >=60) 
  {
    $periode = $temps / 60;

       $entiere = intval($periode);
       $decimale = $periode - $entiere;

       if ($periode > 1) 
       {
         echo "votre licence expire dans $entiere Minutes";
       }
       else
       {
        echo "votre licence expire dans $entiere Minute";
       }
  }

  /*/////////////////////////////////////// CYC POUR LES SECONDE ////////////////////////////////////////*/

    if ($temps <= 59 and $temps >=0) 
  { 
         echo "dans $temps secondes";
  }

?>
