DropDownDataJSON =
{
    "QuestionText" : "ABC Ltd. Şti., otomatil yedek parçaları alım satımı yapmak üzere kurulmuştur. İşletmenin geçmiş dönem sonu bilançosu aşağıda yer almaktadır.",
    "Assessment": [
        {},
        {
            choiceText: "<b>a. </b>15.01.20XX tarihinde işletme alacaklarının 7.000 TL'lik kızmı nakit olarak tahsil etmiştir.",
            table: '<table class="linden-question-table2"><tr><th>AKTİF</th><th colspan="2">ABC Ltd. Şti. 15.01.20XX Tarihli Blançosu</th><th class="alignRight">PASİF</th></tr>' +
                '<tr><td class="etiketWidth">KASA</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_1" /></td><td class="etiketWidth">BORÇLAR</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_5" /></td></tr>'+
                '<tr><td class="etiketWidth">ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_2" /></td><td class="etiketWidth">SERMAYE</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_6" /></td></tr>'+
                '<tr><td class="etiketWidth">TİCARİ MALLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_3" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr><td class="etiketWidth">DEMİRBAŞLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_4" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr class="table-sum-row"><td class="etiketWidth">AKTİF TOPLAM</td><td id="aktifToplam" class="costWidth alignRight"></td><td class="etiketWidth">PASİF TOPLAM</td><td id="pasifToplam" class="rightBorder alignRight"></td></tr>'+
                '</table>',
            correct: ["","17.000","16.000","25.000", "5.000", "10.000","53.000"]
        },
        {
            choiceText: "<b>b. </b>17.01.20XX tarihinde satış ofisinde kullanılmak üzere 3.000 TL tutarında bilgisayar ve 1.000 TL tutarında ofis malzemesi nakit olarak satın alınmıştır.",
            table: '<table class="linden-question-table2"><tr><th>AKTİF</th><th colspan="2">ABC Ltd. Şti. 20.01.20XX Tarihli Blançosu</th><th class="alignRight">PASİF</th></tr>' +
                '<tr><td class="etiketWidth">KASA</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_1" /></td><td class="etiketWidth">BORÇLAR</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_5" /></td></tr>'+
                '<tr><td class="etiketWidth">ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_2" /></td><td class="etiketWidth">SERMAYE</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_6" /></td></tr>'+
                '<tr><td class="etiketWidth">TİCARİ MALLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_3" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr><td class="etiketWidth">DEMİRBAŞLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_4" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr class="table-sum-row"><td class="etiketWidth">AKTİF TOPLAM</td><td id="aktifToplam" class="costWidth alignRight"></td><td class="etiketWidth">PASİF TOPLAM</td><td id="pasifToplam" class="rightBorder alignRight"></td></tr>'+
                '</table>',
            correct: ["","11.000","16.000","25.000", "11.000", "10.000","53.000"]
        },
        {
            choiceText: "<b>c. </b>20.01.20XX tarihinde 15.000 TL tutarındaki ticari mal 32.000 TL'ye satılmış, 10.000 TL nakit, kalan için senet alınmıştır.",
            table: '<table class="linden-question-table2"><tr><th>AKTİF</th><th colspan="2">ABC Ltd. Şti. 20.01.20XX Tarihli Blançosu</th><th class="alignRight">PASİF</th></tr>' +
                '<tr><td class="etiketWidth">KASA</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_1" /></td><td class="etiketWidth">BORÇLAR</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_6" /></td></tr>'+
                '<tr><td class="etiketWidth">ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_2" /></td><td class="etiketWidth">SERMAYE</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_7" /></td></tr>'+
                '<tr><td class="etiketWidth">SENETLİ ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_3" /></td><td class="etiketWidth">KAR</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_8" /></td></tr>'+
                '<tr><td class="etiketWidth">TİCARİ MALLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_4" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr><td class="etiketWidth">DEMİRBAŞLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_5" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr class="table-sum-row"><td class="etiketWidth">AKTİF TOPLAM</td><td id="aktifToplam" class="costWidth alignRight"></td><td class="etiketWidth">PASİF TOPLAM</td><td id="pasifToplam" class="rightBorder alignRight"></td></tr>'+
                '</table>',
            correct: ["","21.000","16.000","22.000", "10.000", "11.000","10.000","53.000","17.000"]
        },
        {
            choiceText: "<b>d. </b>23.01.20XX tarihinde işletme borçlarını nakit olarak ödemiştir.",
            table: '<table class="linden-question-table2"><tr><th>AKTİF</th><th colspan="2">ABC Ltd. Şti. 23.01.20XX Tarihli Blançosu</th><th class="alignRight">PASİF</th></tr>' +
                '<tr><td class="etiketWidth">KASA</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_1" /></td><td class="etiketWidth">SERMAYE</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_6" /></td></tr>'+
                '<tr><td class="etiketWidth">ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_2" /></td><td class="etiketWidth">KAR</td><td class="rightBorder alignRight"><input type="text" class="dictionaryTextInput pasif" maxlength="7" id="textBox_7" /></td></tr>'+
                '<tr><td class="etiketWidth">SENETLİ ALACAKLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_3" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr><td class="etiketWidth">TİCARİ MALLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_4" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr><td class="etiketWidth">DEMİRBAŞLAR</td><td class="costWidth alignRight"><input type="text" class="dictionaryTextInput aktif" maxlength="7" id="textBox_5" /></td><td class="etiketWidth"></td><td class="rightBorder alignRight"></td></tr>'+
                '<tr class="table-sum-row"><td class="etiketWidth">AKTİF TOPLAM</td><td id="aktifToplam" class="costWidth alignRight aktif"></td><td class="etiketWidth">PASİF TOPLAM</td><td id="pasifToplam" class="rightBorder alignRight"></td></tr>'+
                '</table>',
            correct: ["","11.000","16.000","22.000", "10.000", "11.000","53.000","17.000"]
        }




   ]
};