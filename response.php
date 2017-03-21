<?php
//sleep(1);
$body = <<<BODY
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
      <GetTaxiInfosResponse xmlns="http://dtis.mos.ru/taxi">
         <GetTaxiInfosResult>
            <TaxiInfo>
               <LicenseNum>02651</LicenseNum>
               <LicenseDate>08.08.2011 0:00:00</LicenseDate>
               <Name>ООО "НЖТ-ВОСТОК"</Name>
               <OgrnNum>1107746402246</OgrnNum>
               <OgrnDate>17.05.2010 0:00:00</OgrnDate>
               <Brand>FORD</Brand>
               <Model>FOCUS</Model>
               <RegNum>EM33377</RegNum>
               <Year>2011</Year>
               <BlankNum>002695</BlankNum>
               <Info/>
            </TaxiInfo>
         </GetTaxiInfosResult>
      </GetTaxiInfosResponse>
   </s:Body>
</s:Envelope>
BODY;

echo $body;
