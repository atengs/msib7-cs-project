Ekpor PDF BELUM TERHITUNG ONE PROJECT/ RETAINER dan juga belum ada penambahan Discount

async exportPdf1(id) { 
    const mythis = this;
    mythis.$root.presentLoading();

  try {
      const reqData = await axios({
          method: 'get',
          url: mythis.$root.apiHost + `api/trx-header/${id}`,
      });

      const resData = reqData.data.data;
      const header = resData.header;
      const details = resData.ratecards;

      const pph23Text = header.pph23 ? "Sudah termasuk PPh 23" : "Belum termasuk PPh 23";
      const ppnText = header.ppn ? "Sudah termasuk PPN" : "Belum termasuk PPN";

      const doc = new jsPDF('p', 'pt', 'a4');

    
      const logo = new Image();
      logo.src = '/src/assets/img/creativestyle.jpeg'; 
      doc.addImage(logo, 'JPEG', 35, 20, 80, 80); 


      const boxX = 340;
      const boxY = 27;
      const boxWidth = 200; 
      const boxHeight = 15;

      doc.setFillColor(255, 153, 203); 
      doc.rect(boxX, boxY, boxWidth, boxHeight, 'F'); 

      doc.setFontSize(5);
      doc.setFont("helvetica", "bold");
      doc.setTextColor(0, 0, 0); 

      
      const jobText = `${header.job}`;
      let textX;
      if (jobText.length ) {
          
          textX = boxX + boxWidth / 2 - doc.getTextWidth(jobText) / 2;
      } else {
          
          textX = boxX + 10;
      }
      doc.text(jobText, textX, boxY + 10);
      
      doc.setFontSize(7);
      doc.text('PENAWARAN HARGA', 250, 100);

      const labelX = 40;
      const colonX = 230;
      const valueX = 250;
      doc.setFontSize(6);
      doc.setFont("helvetica", "normal");

      doc.text('Company', labelX, 130);
      doc.text(':', colonX, 130);
      doc.text(`${header.customer}`, valueX, 130);

      doc.text('Person In Charge', labelX, 150);
      doc.text(':', colonX, 150);
      doc.text(`${header.person_in_charge}`, valueX, 150);

      doc.text('Address', labelX, 170);
      doc.text(':', colonX, 170);
      const addressText = doc.splitTextToSize(`${header.address}`, 260); 
      doc.text(addressText, valueX, 170);
      
      doc.text('Project/Produk', labelX, 190);
      doc.text(':', colonX, 190);
      doc.text(`${header.project}`, valueX, 190);

      doc.text('Job', labelX, 210);
      doc.text(':', colonX, 210);
      doc.text(`${header.job}`, valueX, 210);

      doc.text('No Pesanan', labelX, 230);
      doc.text(':', colonX, 230);
      doc.text(`${header.trans_number}`, valueX, 230);


      
      const ratecards = details.map((detail, index) => {
      const totalAwal = parseFloat(detail.ratecard_nominal); // Tetap 15 juta misalnya
      const totalAwalDenganQty = totalAwal * parseInt(detail.qty); // Hitung total awal berdasarkan qty
      let totalAkhir;

      if  (detail.business_type === 'Perorangan') {
      totalAkhir = Math.floor(totalAwalDenganQty / 0.97 / 0.98);
      } 
      else if (detail.business_type === 'Badan Usaha') {
      totalAkhir = Math.floor(totalAwalDenganQty / 0.98);
      }

      return [
      index + 1,
      detail.job_description,
      `${detail.qty} master`,
      `Rp. ${new Intl.NumberFormat('en-US').format(totalAwal)}`,
      `Rp. ${new Intl.NumberFormat('en-US').format(totalAkhir)}    `,
      detail.note
  ];
});

   // const ratecards = details.map((detail, index) => [
      //     index + 1,
      //     detail.job_description,
      //     '2 Derivative (HC)',
      //     `Rp. ${new Intl.NumberFormat('en-US').format(detail.ratecard_nominal)}`,
          
      //     '12.653.061 (HardCore)    ',
      //     detail.note
      // ]);

      const totalAkhirSum = details.reduce((sum, detail) => {
      const totalAwal = parseFloat(detail.ratecard_nominal) * parseInt(detail.qty);
      let totalAkhir;

      if (detail.business_type === 'Perorangan') {
          totalAkhir = Math.floor(totalAwal / 0.97 / 0.98);
      } else if (detail.business_type === 'Badan Usaha') {
          totalAkhir = Math.floor(totalAwal / 0.98);
      }

      return sum + totalAkhir;
    }, 0);

      const agencyFeePercentage = header.agency_fee;
      const agencyFeeValue = Math.floor((totalAkhirSum * agencyFeePercentage) / 100);
      
      const totalBudget = totalAkhirSum + agencyFeeValue;

      const term = header.term || 1; // Default ke 1 jika term tidak ada
      const monthlyValue = Math.floor(totalBudget / term);
      const totalBudgetTerbilang = convertToTerbilang(totalBudget) + " Rupiah";
      

    
      
      ratecards.push([
      ratecards.length + 1,
      `AGENCY FEE ${header.agency_fee}%`,
      ``, 
      ``, 
      `Rp. ${new Intl.NumberFormat('id-ID').format(agencyFeeValue)}    `, 
      ``
  ]);
      


      doc.autoTable({
          startY: 240,
          head: [['No', '              Hal','','', '           Total  ', '                        Note']],
          body: ratecards,
          theme: 'plain',
          styles: {
              fontSize: 6,
              fillColor: [255, 255, 255],
              textColor: [0, 0, 0]
          },
          headStyles: {
              fillColor: [255, 255, 255],
              textColor: [0, 0, 0],
          },
          tableWidth: 500, 
          columnStyles: {
                0: { cellWidth: 20 },       
                1: { cellWidth: 130 },   
                2: { cellWidth: 50 },     
                3: { cellWidth: 60, halign: 'right' },       
                4: { cellWidth: 70 , halign: 'right' }, 
                // 3: { cellWidth: 70, halign: 'right' }, 
                5: { cellWidth: 170 },      
          },

          didDrawCell: function (data) {
              if (data.section === 'head') {
                  const doc = data.doc;
                  const cell = data.cell;

                  if (data.row.index === 0) {
                      doc.setLineWidth(1);
                      doc.setDrawColor(0, 0, 0); 
                      doc.line(cell.x, cell.y, cell.x + cell.width, cell.y);
                  }

                  if (data.row.index === 0 && data.cell.raw === 'Note', 'ratecard_nominal') {
                      doc.setLineWidth(2);
                      doc.setDrawColor(0, 0, 0); 
                      doc.line(cell.x, cell.y + cell.height, cell.x + cell.width  , cell.y + cell.height);
                  } 
              }
          }
        });

        
      let finalY = doc.lastAutoTable.finalY + 5;
      const pageWidth = doc.internal.pageSize.getWidth();

      doc.line(40, finalY -5, 540, finalY -5);

      doc.text('  Total Budget:', 40, finalY + 5);
      doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(totalBudget)}`,pageWidth - 237,  finalY + 5,{ align: 'right' });
      doc.setDrawColor(0, 0, 0);

      doc.setFillColor (255, 153, 203);
      doc.rect(labelX, finalY + 11, 500, 15, 'F');

      doc.line(labelX, finalY + 10, labelX + 500, finalY + 10); 
      doc.line(labelX, finalY + 11, labelX + 500, finalY + 11); 

      doc.line(labelX, finalY + 26, labelX + 500, finalY + 26);
      doc.line(labelX, finalY + 27, labelX + 500, finalY + 27);
      
      // doc.text(`  Monthly : ${header.term} Month `, labelX, finalY + 20);
      doc.text(`  Monthly : `, labelX, finalY + 20);
      doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(monthlyValue)}`,pageWidth - 237,  finalY + 20,{ align: 'right' });

      doc.text(`  Terbilang : ${totalBudgetTerbilang}`, labelX, finalY + 37);
      
      doc.line(labelX, finalY + 42, 540, finalY + 42);
      doc.line(labelX, finalY + 43, 540, finalY + 43);

    
      finalY += 40;
      doc.setFontSize(7);
      
      finalY += 15;
      doc.text(pph23Text, labelX, finalY); 
      finalY += 15;
      const ppnTextWithPercent = `${ppnText} ${header.ppn_percent}%`;
      doc.text(ppnTextWithPercent, labelX, finalY);
      
      finalY += 15;
      doc.text(`Pekerjaan akan dilakukan oleh CS setelah ada pembayaran DP minimal 50% dari Brand.`, labelX, finalY);
      finalY += 15;
      doc.text(`Bila disetujui, mohon approval dari quotation ini di email, dan dikirimkan kembali ke CS.`, labelX, finalY);
      finalY += 15;
      doc.text(`PO/PP segera dikeluarkan langsung setelah quotation di approve.`, labelX, finalY);

      // FUNCTION
      function convertToTerbilang(num) {
      const satuan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
      if (num < 12) return satuan[num];
      if (num < 20) return satuan[num - 10] + " Belas";
      if (num < 100) return satuan[Math.floor(num / 10)] + " Puluh " + satuan[num % 10];
      if (num < 200) return "Seratus " + convertToTerbilang(num - 100);
      if (num < 1000) return satuan[Math.floor(num / 100)] + " Ratus " + convertToTerbilang(num % 100);
      if (num < 2000) return "Seribu " + convertToTerbilang(num - 1000);
      if (num < 1000000) return convertToTerbilang(Math.floor(num / 1000)) + " Ribu " + convertToTerbilang(num % 1000);
      if (num < 1000000000) return convertToTerbilang(Math.floor(num / 1000000)) + " Juta " + convertToTerbilang(num % 1000000);
      return convertToTerbilang(Math.floor(num / 1000000000)) + " Miliar " + convertToTerbilang(num % 1000000000);
      } 

      function capitalizeEachWord(text) {
        return text.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
      }

      finalY += 40;
      doc.text('Terima Kasih', labelX, finalY );

      doc.setFontSize(7);
      
      doc.text(capitalizeEachWord(`${header.acount_executive}`), labelX, finalY + 75);
      doc.text('Account Executive', labelX, finalY + 85);

      doc.text(capitalizeEachWord(`${header.acount_manager}`), 200, finalY + 75);
      doc.text('Account Manager', 200, finalY + 85);

      doc.text(capitalizeEachWord(`${header.finance_manager}`), 300, finalY + 75);
      doc.text('Finance Manager', 300, finalY + 85);


      doc.setFontSize(7);
      doc.text('Tanggal', 400, finalY ); 
      doc.text('Disetujui Oleh : ', 400, finalY + 15);
      doc.text('Klien : ', 400, finalY + 85);

      // Simpan file PDF
      const fileName = `Quotation_${header.trans_number}.pdf`;
      doc.save(fileName);

      mythis.$root.stopLoading();
      Swal.fire('Success', 'PDF has been generated successfully', 'success');
  } catch (error) {
      console.error('Error generating PDF:', error);
      mythis.$root.stopLoading();
      Swal.fire('Error', 'Failed to generate PDF', 'error');
  }
},
