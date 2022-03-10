<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
</head>
<style type="text/css">

</style>

<body>
<tr>
    <td>
        <table width="100%" cellpadding="0" cellspacing="0"
            style="background-color:#ebeff2;width: 100%;text-align: center;font-family: 'Poppins', sans-serif !important;">
            <tbody>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: bold;font-size: 38px;color: #000;">
                       User Review</td>
                </tr> 
                <tr>
                    <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 20px;color: #616161;">
                        for purchased e-mock </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td height="15px"></td>
</tr>

<tr>
           <td>
               <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;font-family: 'Poppins', sans-serif !important;background-color: #ffffff;">
                   <tbody>
                      <tr>
                          <td width="30px"></td>
                          <td width="740px">
                              <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                                  <tbody>
                                    <tr><td style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #616161;"><p><b>Hi Admin,</b></p></td></tr>

                                    

                                    <tr><td style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #616161;"><p> You have received a review for <b>{{ $mocktitle}}</b> by user <b>{{ $username }}</b></p></td></tr>
                                    
                                   
                                    <tr><td height="15px"></td></tr>
                                    
                                    <tr><td height="15px"></td></tr>
                                    <tr>
                                        <!-- <td>
                                            <table width="100%" cellpadding="0" cellspacing="0"   style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                                            
                                                <tbody>
                                                   <tr>
                                                       <td><input type="radio" name="rate" id="radio_rating1" value="5" checked style="width: 15px;height: 15px;"/><span><img src={{ asset("frontend/images/templates/5_star.png") }}></span></td>
                                                       <td><input type="radio" name="rate" id="radio_rating2" value="4" style="width: 15px;height: 15px;"/><span><img src={{ asset("frontend/images/templates/4_star.png") }}></span></td>
                                                       <td><input type="radio" name="rate" id="radio_rating3" value="3" style="width: 15px;height: 15px;"/><span><img src={{ asset("frontend/images/templates/3_star.png") }}></span></td>
                                                       <td><input type="radio" name="rate" id="radio_rating4" value="2" style="width: 15px;height: 15px;"/><span><img src={{ asset("frontend/images/templates/2_star.png") }}></span></td>
                                                       <td><input type="radio" name="rate" id="radio_rating5" value="1" style="width: 15px;height: 15px;"/><span><img src={{ asset("frontend/images/templates/1_star.png") }}></span></td>
                                                   </tr>
                                                   <tr><td colspan="5" height="15px"></td></tr>
                                                   <tr>
                                                       <td colspan="5">
                                                            <label>Write your review</label></br>
                                                           <textarea name="content" placeholder="Write your review here" style="width: 100%;height: 90px;border: 1px solid #d0d0d0;resize:none;padding: 5px;font-family: 'Poppins', sans-serif !important;font-size: 13px;font-weight: 400;color: #424242;"></textarea>
                                                        </td>
                                                    </tr>
                                                   <tr><td colspan="5" height="15px"></td></tr>
                                                   <tr><td colspan="5">
                                                    <input type="submit" style="box-sizing:border-box;font-family:'Poppins',sans-serif!important;font-size:14px;color:#ffffff;font-weight:600;border-radius:0;border:none!important;outline:none!important;background-color:#03a9f4;padding:10px 30px;text-decoration:none!important" value="Submit Your Review">
                                                      {{-- <button type="submit" style="font-family: 'Poppins', sans-serif !important;font-size: 14px;color: #FFFFFF;font-weight: 600;border-radius: 0;border: none !important;outline: none !important;background-color: #03a9f4;padding: 10px 30px;box-shadow: none !important;text-decoration: none !important;cursor: pointer;" >Submit Your Review</button> --}}
                                                   </td></tr>
                                                   <tr><td colspan="5" height="15px"></td></tr>
                                                </tbody>

                                                <input type="hidden" name="order_uuid" value="{{ @$order->uuid }}">
                                                <input type="hidden" name="paper_uuid" value="{{ @$item->paper->uuid }}">
                                             
                                            </table>
                                        </td> -->
                                        <td>
                                        Rating : <b>{{ $rating }}</b>
                                        </td>
                                        <td>
                                        Review : <b>{{ $review }}</b>
                                        </td>
                                    </tr>   
                                    @php
                                        $faqs = getFooterFaqs();
                                    @endphp
                                    @include('frontend.template.faq',['faqs' => $faqs])
                                  </tbody>
                              </table>
                          </td>
                          <td width="30px"></td>
                      </tr>
                   </tbody>
               </table>
           </td>
       </tr> 

 
       <tr>
         <td>
             <table width="100%" cellpadding="0" cellspacing="0"
                 style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                 <tbody>
                     <tr>
                         <td>
                             <table width="100%" cellpadding="0" cellspacing="0"
                                 style="background: #42a5f5 url({{ asset('frontend/images/templates/footer_bg.png') }}) repeat 0 0;width: 100%;text-align: center;">
                                 <tbody>
                                     <tr>
                                         <td style="height: 20px;"></td>
                                     </tr>
                                     <tr>
                                         <td width="350px" style="width: 350px;margin: 0 auto">
                                             <a href="{{ route('about') }}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;margin-right: 20px;">About</a>
                                             <a href="{{ route('blogs/index') }}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;margin-right: 20px;">Blog</a>
                                             <a href="{{route('contact-us')}}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;">Contact
                                                 Us</a>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td style="height: 20px;"></td>
                                     </tr>
                                     <tr>
                                         <td width="350px" style="width: 350px;margin: 0 auto">
                                             <a href="{{ route('cms_privacy') }}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;margin-right: 20px;padding-right:20px;border-right: 1px solid #ffffff;">Privacy
                                                 Policy</a>
                                             <a href="{{ route('cms_terms') }}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;margin-right: 20px;padding-right:20px;border-right: 1px solid #ffffff;">Terms
                                                 of Services</a>
                                             <a href="{{ route('faq',['slug' =>  @$faqs[0]->frontendFaqs ? @$faqs[0]->frontendFaqs[0]->slug : 'not-found' ]) }}"
                                                 style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #ffffff;text-decoration: none;">FAQ</a>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td style="height: 20px;"></td>
                                     </tr>
                                 </tbody>
                             </table>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <table width="100%" cellpadding="0" cellspacing="0"
                                 style="background-color: #1a237e;width: 100%;font-family: 'Poppins', sans-serif !important;">
                                 <tr>
                                     <td style="height: 10px;"></td>
                                 </tr>
                                 <tr>
                                     <td
                                         style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 10px;color: #ffffff;text-align: center;">
                                         © {{ date('Y') }} All right reserved. {{config('app.name')}}</td>
                                 </tr>
                                 <tr>
                                     <td style="height: 10px;"></td>
                                 </tr>
                             </table>
                         </td>
                     </tr>
                 </tbody>
             </table>
         </td>
     </tr>
     </body>

</html>