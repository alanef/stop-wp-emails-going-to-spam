��    ;      �  O   �           	          '  +   E  �   q  T   %     z     �     �  k   �  �   )     �  *   �  +   �                    $  #   ?     c    {  '   ~	  
   �	     �	     �	     �	     �	  >   �	     #
     ,
     H
  T   e
  k   �
  J   &  �   q  ?   2  �   r  �   �  @   �  K   �          -     F  L   X  i   �          .  �   E  b   �  M   0  �   ~  v   O  .   �     �  D        P  '   `  ?   �  {  �     D     Y  )   e  7   �  �   �  c   �           ;     O  �   ^  �   �     q  +     (   �     �     �     �     �  /        1    N  '   k  
   �     �     �      �     �  >   �     (  &   0  -   W  m   �  �   �  ]   �  �   �  Z   �  �     �   �  Y   v  i   �  !   :   +   \      �   U   �   �   �   "   �!     �!  �   �!  m   L"  c   �"  #  #  �   B$  B   �$     %  D   1%     v%  !   �%  R   �%     '      #   
   %   9         .       +   )           $       &                 *   7         0   3                   -   6   !       2         5   ,                  "                  (         /                                8      4           :                 ;   1   	           About this Plugin Alan Fuller Are you sure want to do this? Cannot execute as the plugin already exists Cannot get DNS records - refresh this page - if you still get this message after a few refreshes you may want to check your domain DNS control panel or check via a third part tool Cannot identify a valid IP address - you may want to check with your hosting company Current record SPF record for Domain being checked Envelope Sender Fixes WordPress PHP-Mailer emails going to spam/junk folders. The default settings often resolve the issue. For best results the "envelope sender" domain should have a SPF record, see the SPF section, and the email address should exist. From Address Good!, this contains an A record reference Good!, this contains your server IP address IPv4 IPv6 Information Invalid email for Envelope Invalid email for WordPress default No SPF record found for Note about ~all.  ~all is a soft fail and is normally used,  however some services relay emails and O365 does not like it if the originating SPF is weaker than the relay SPF. If you are  having issues with O365/Outlook/Hotmail try using -all rather than ~all Recommend you add +a to your SPF record SPF Record Save Save Options Sending Health Check Server Info Set the relationship between From address and Envelope address Settings Settings reset to defaults. Stop WP Emails Going to Spam The SPF redirects to another domain, recommend you manually check the redirected SPF This plugin tries to help you stop emails being sent to spam folders when sent from your WordPress website. This plugin will only set the "envelope sender" if other plugins have not. This sets envelope sender of the message, if not set by another program. This will usually be turned into a Return-Path header by the receiver, and is the address that bounces will be sent to. Tick and set an email name on your domain for the default email Tick to leave the From address alone - this may raise warnings in email clients when different from Envelope, not generally recommended Tick to set the Envelope to the From, not recommended unless all your forms use a From address of your domain, however the SPF check below is ignored Tick to set the From to the same as Envelope (above) recommended Tick to set the WP default to the same as the email set above - recommended Use Admin Email Use another Domain email Use another email Use the settings to select the email that you want as the "envelope sender". When using the default PHP mailer on shared hosts WordPress does not correctly set the "envelope sender". WordPress default mail address WordPress default name WordPress default system messages come from an account WordPress &lt;wordpress@%s&gt;  you can control that with the following settings You can change the display name associated with the default WordPress email, this is cosmetic only You can use an email like noreply@%s, but make sure the email account exists. You can use another fully qualified email, but make sure the email account exists and the domain has correct SPF set up. No point using gmail or outlook or domains you don't own as you will never make it work You do not need this plugin if you are using an SMTP email plugin or using an API based / transactional email solution Your IP appears in one or more spam blacklists http://fullworks.net/ http://fullworks.net/wordpress-plugins/stop-wp-emails-going-to-spam/ spam blacklists the following SPF record is recommended you may want to talk to your host to resolve your IP reputation Project-Id-Version: plugin-donation-lib
Report-Msgid-Bugs-To: https://wordpress.org/support/plugin/stop-wp-emails-going-to-spam
PO-Revision-Date: 
Last-Translator: 
Language-Team: 
Language: tr_TR
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=(n != 1);
X-Poedit-Basepath: ..
X-Poedit-KeywordsList: __;_e;_ex:1,2c;_n:1,2;_n_noop:1,2;_nx:1,2,4c;_nx_noop:1,2,3c;_x:1,2c;esc_attr__;esc_attr_e;esc_attr_x:1,2c;esc_html__;esc_html_e;esc_html_x:1,2c
X-Poedit-SourceCharset: UTF-8
X-Generator: Poedit 3.5
X-Poedit-SearchPath-0: .
X-Poedit-SearchPathExcluded-0: *.js
 Bu Eklenti Hakkında Alan Fuller Bunu yapmak istediğinizden emin misiniz? Eklenti zaten mevcut olduğundan çalıştırılamıyor DNS kayıtları alınamıyor - bu sayfayı yenileyin - birkaç yenilemeden sonra hala bu mesajı alıyorsanız, alan adı DNS kontrol panelinizi kontrol etmek veya üçüncü taraf bir araç aracılığıyla kontrol etmek isteyebilirsiniz Geçerli bir IP adresi tanımlanamıyor - barındırma şirketinizle kontrol etmek isteyebilirsiniz Için geçerli kayıt SPF kaydı Kontrol edilen alan Zarf Gönderen WordPress PHP-Mailer e-postalarının spam/önemsiz klasörlere gitmesini düzeltir. Varsayılan ayarlar genellikle sorunu çözer. En iyi sonuçlar için "zarf gönderen" alan adının bir SPF kaydı olmalıdır, SPF bölümüne bakın ve e-posta adresi mevcut olmalıdır. Kimden Adresi Güzel!, bu bir A kaydı referansı içerir Güzel!, bu sunucu IP adresinizi içerir IPv4 IPv6 Bilgi Zarf için geçersiz e-posta WordPress varsayılanı için geçersiz e-posta Için SPF kaydı bulunamadı All hakkında not.  ~all yumuşak bir başarısızlıktır ve normalde kullanılır, ancak bazı hizmetler e-postaları aktarır ve kaynak SPF aktarım SPF'sinden daha zayıfsa O365 bundan hoşlanmaz. O365/Outlook/Hotmail ile sorun yaşıyorsanız ~all yerine -all kullanmayı deneyin SPF kaydınıza +a eklemenizi öneririz SPF Kaydı Kaydet Seçenekleri Kaydet Sağlık Kontrolü Gönderiliyor Sunucu Bilgisi Kimden adresi ile Zarf adresi arasındaki ilişkiyi ayarlayın Ayarlar Ayarlar varsayılanlara sıfırlandı. WP E-postalarının Spam'e Gitmesini Durdurun SPF başka bir etki alanına yönlendiriliyor, yönlendirilen SPF'yi manuel olarak kontrol etmenizi öneririz Bu eklenti, WordPress web sitenizden gönderildiğinde e-postaların spam klasörlerine gönderilmesini durdurmanıza yardımcı olmaya çalışır. Bu eklenti yalnızca diğer eklentiler ayarlamamışsa "zarf göndericisini" ayarlayacaktır. Bu, başka bir program tarafından ayarlanmamışsa, iletinin zarf göndericisini ayarlar. Bu genellikle alıcı tarafından bir Return-Path başlığına dönüştürülür ve geri dönenlerin gönderileceği adrestir. Varsayılan e-posta için alan adınızdaki bir e-posta adını işaretleyin ve ayarlayın Kimden adresini tek başına bırakmak için işaretleyin - bu, Zarf'tan farklı olduğunda e-posta istemcilerinde uyarılara neden olabilir, genellikle önerilmez Zarfı Kimden olarak ayarlamak için işaretleyin, tüm formlarınız alan adınızın Kimden adresini kullanmıyorsa önerilmez, ancak aşağıdaki SPF kontrolü göz ardı edilir Kimden öğesini Zarf (yukarıda) önerilen ile aynı olarak ayarlamak için işaretleyin WP varsayılanını yukarıda ayarlanan e-posta ile aynı olarak ayarlamak için işaretleyin - önerilir Yönetici E-postasını Kullanın Başka bir Etki Alanı e-postası kullanın Başka bir e-posta kullanın "Zarf göndericisi" olarak istediğiniz e-postayı seçmek için ayarları kullanın. Paylaşımlı ana bilgisayarlarda varsayılan PHP mailer kullanıldığında WordPress "zarf göndericisini" doğru şekilde ayarlamaz. WordPress varsayılan posta adresi WordPress varsayılan adı WordPress varsayılan sistem mesajları WordPress &lt;wordpress@%s&gt hesabından gelir; bunu aşağıdaki ayarlarla kontrol edebilirsiniz Varsayılan WordPress e-postası ile ilişkili görünen adı değiştirebilirsiniz, bu yalnızca kozmetiktir Noreply@%s gibi bir e-posta kullanabilirsiniz, ancak e-posta hesabının var olduğundan emin olun. Başka bir tam nitelikli e-posta kullanabilirsiniz, ancak e-posta hesabının mevcut olduğundan ve alan adının doğru SPF ayarına sahip olduğundan emin olun. Gmail, outlook veya sahip olmadığınız alan adlarını kullanmanın bir anlamı yoktur, çünkü asla çalıştıramazsınız Bir SMTP e-posta eklentisi kullanıyorsanız veya API tabanlı / işlemsel bir e-posta çözümü kullanıyorsanız bu eklentiye ihtiyacınız yoktur IP adresiniz bir veya daha fazla spam kara listesinde görünüyor http://fullworks.net/ http://fullworks.net/wordpress-plugins/stop-wp-emails-going-to-spam/ spam kara listeleri aşağıdaki SPF kaydı önerilir IP itibarınızı çözmek için ana bilgisayarınızla konuşmak isteyebilirsiniz 