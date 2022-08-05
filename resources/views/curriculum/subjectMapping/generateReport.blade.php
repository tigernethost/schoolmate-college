<!DOCTYPE html>	
<head>
	<title>{{Config::get('settings.schoolname')}} | Enrolment List</title>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


	<style>
		{{-- @include('bootstrap4') --}}
		
		table td, table th {
			border: 0 !important;
			padding: 1px !important;
			font-size: 10px;
			background-color: #3c8dbc;
		}
		/*table.profile {border: 0.5px solid #ddd;}*/

		.profilediv {
			border: 1px solid #ddd;
			border-radius: 5px;
			margin-bottom: 10px;
			padding: 5px;
		}

		.signature-over-printed-name p {
			font-size: 9px;
			/*font-weight: 700;*/
		}
		
		/*footer { 
			position: fixed;
			bottom: -0px; 
			height: 50px;
			font-size: 10px;

		}*/

		@media screen {
		  footer {
		    display: none;
		  }
		}
		@media print {
			footer {
				position: fixed;
				bottom: 0;
				left: 0;
				right: 0;
			}

			.pagebreak {
		        clear: both;
		        page-break-before: always;
		    }
		 /*	#table-body {
		 		margin: 25mm 25mm 25mm 25mm;
		 	}*/

		}

	
	</style>


</head>
<body>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> --}}
	{{-- <script src="https://unpkg.com/jspdf@1.5.3/dist/jspdf.min.js"></script> --}}
	<script src="{{ asset('js/jspdf.min.js') }}"></script>
	<script src="{{ asset('js/jspdf.plugin.autotable.js') }}"></script>

	<script>
		(function(API){
		    API.myText = function(txt, options, x, y) {
		        options = options ||{};
		        /* Use the options align property to specify desired text alignment
		         * Param x will be ignored if desired text alignment is 'center'.
		         * Usage of options can easily extend the function to apply different text 
		         * styles and sizes 
		        */
		        if( options.align == "center" ){
		            // Get current font size
		            var fontSize = this.internal.getFontSize();

		            // Get page width
		            var pageWidth = this.internal.pageSize.width;

		            // Get the actual text's width
		            /* You multiply the unit width of your string by your font size and divide
		             * by the internal scale factor. The division is necessary
		             * for the case where you use units other than 'pt' in the constructor
		             * of jsPDF.
		            */
		            txtWidth = this.getStringUnitWidth(txt)*fontSize/this.internal.scaleFactor;

		            // Calculate text's x coordinate
		            x = ( pageWidth - txtWidth ) / 2;
		        }

		        // Draw text at x,y
		        this.text(txt,x,y);
		    }
		})(jsPDF.API);

		var statistics_x = 109;
		var statistics_y = 61;
		var num = 2;
    	var doc = new jsPDF('l');
	    // It can parse html:
	    
	    // Or use javascript directly:
	    // BODY LIST
        var body = 	[
					@foreach($subjectDatas as $key => $subjectData)
                    [
						
			        	'{{ $subjectData->subject_code }}',
						@if($subjectData->subject_title != null)
							'{{ $subjectData->subject_title }}',
						@else
							' -',
						@endif
						'{{ $subjectData->subject_description }}',
						'{{ $subjectData->percentage }}',
						'{{ number_format( (float) $subjectData->no_unit, 1, '.', '')  }}',
						@if($subjectData->additional_fee != null)
							'{{ $subjectData->additional_fee }}'
						@else
							' -',
						@endif

					],
					@endforeach
	        		];

	    // TABLE
	    doc.autoTable({
	    	headStyles:{
	    		fillColor: '#3c8dbc'
	    	},
	    		// HEADER
                head: [[
					{content: "Subject Code", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
					{content: "Title", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
					{content: "Description", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
					{content: "Percentage", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
					{content: "No. Of Units", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
	        		{content: "Additional Price", styles: { valign: 'middle', halign: 'center' ,fontStyle: 'bold' }},
	        	
	        ]],
	        // BODY
	        body: body,
			tableWidth: 'auto',
	        styles: {
	        	whiteSpace: 'nowrap',
	        	fontSize: 7,
	        	cellPadding: 1
	        },
	        bodyStyles: {
	        	width: 'auto'
	        },
	        showFoot: 'everyPage',
	        showHead: 'everyPage',
	        theme: 'grid',
            columns: [
		        { header: "Subject Code", dataKey: "code" },
		        { header: "Title", dataKey: "title" },
		        { header: "Description", dataKey: "desc" },
		        { header: "Percentage", dataKey: "percentage" },
		        { header: "No. Of Units", dataKey: "units" },
				{ header: "Additional Price", dataKey: "addprice" }
		    
		    ],
		    columnStyles: {
		        code: { columnWidth: 60 },
		        title: { columnWidth: 90},
		        percentage: { columnWidth: 15},
				units: { columnWidth: 15},
				addprice: { columnWidth: 15},
		    },
	        // columnStyles: {europe: {halign: 'center'}}, 


	        didDrawPage: function (data) {
	         // SCHOOL LOGO
             var base64Img = "{{ $schoollogo }}";
				 if (base64Img) {
	                doc.addImage(base64Img, 'PNG', (data.settings.margin.left * data.settings.margin.right ) / 1.4, 6, 12, 12);
	            }

	            // SCHOOL NAME
	            doc.setFontSize(9);
	            doc.setFontType("bold");
	            doc.myText("{{ strtoupper(config('settings.schoolname')) }}",{align: "center"},0,25);
				
				// SCHOOL ADDRESS
	            doc.setFontSize(6.5);
	            doc.setFontType("normal");
	            doc.myText("{{ Config::get('settings.schooladdress') }}", {align: "center", },0,28);

 
	            // TITLE
	            doc.setFontSize(8);
	            doc.setFontType("bold");
	            doc.myText("SUBJECT MAPPING", {align: "center"},0,40);
	            
	            // AS OF {DATE}
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.setFontStyle('italic');
	            doc.myText("as of {{ Carbon\Carbon::today()->format('M. d, Y') }}", {align: "center", fontStyle: "italic"},0,44);

	            // Curriculum
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.text("Curriculum: ", data.settings.margin.left, 55);

	            // Curriculum...
	            doc.setFontType("bold");
	            doc.text("{{ $entry->curriculum ? $entry->curriculum->curriculum_name : '-' }}", data.settings.margin.left + 20, 55);

	            // DEPARTMENT
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.text("Department: ", data.settings.margin.left, 60);

	            // DEPARTMENT: Grade School, Senior High, etc..
	            doc.setFontType("bold");
	            doc.text("{{ $entry->department ? $entry->department->name : '-' }}", data.settings.margin.left + 20, 60);

	           // LEVEL
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.text("Level: ", data.settings.margin.left, 65);

	            // LEVEL: Grade 1, Grade 2, Grade 3, etc...
	            doc.setFontType("bold");
	            doc.text("{{ $entry->level ? $entry->level->year : '-' }}", data.settings.margin.left + 20, 65);


				@if($entry->track)
				// Track
				doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.text("Track: ", data.settings.margin.left, 65);

	            // Track: ...
	            doc.setFontType("bold");
	            doc.text("{{ $entry->track ?  $entry->track->code  : '-' }}", data.settings.margin.left + 20, 65);

				@endif

	           
	            // (FOOTER)
	            // Footer
	            var str = "Page " + doc.internal.getNumberOfPages()

	            // Total page number plugin only available in jspdf v1.0+
	            if (typeof doc.putTotalPages === 'function') {
	                str = str;
	            }
	            // doc.setFontSize(10);

	            // jsPDF 1.4+ uses getWidth, <1.4 uses .width
	            var pageSize = doc.internal.pageSize;
	            var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();

	            // SchoolMATE LOGO
	            var base64Img = "{{ $schoolmate_logo }}";
	            // if (base64Img) {
	            //     doc.addImage(base64Img, 'PNG', (data.settings.margin.left * data.settings.margin.right ) / 2, pageHeight - 33, 12, 15);
	            // }
	            if (base64Img) {
	                doc.addImage(base64Img, 'PNG',  270, pageHeight - 21, 10, 12);
	            }

	            // COPYRIGHT {DATE}
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.myText("Copyright  © {{ Carbon\Carbon::today()->format('Y') }}", {align: "center", fontStyle: "italic"},0, pageHeight - 15);

	            // Powered by: Tigernet Hosting and IT Services
	            doc.setFontSize(8);
	            doc.setFontType("normal");
	            doc.myText("Powered by: Tigernet Hosting and IT Services", {align: "center", fontStyle: "italic"},0, pageHeight - 10);

	            // NEXT PAGE X AND Y FOR STATISTICS
	            statistics_x = 109;
				statistics_y = 61;
				num = 2;

	            doc.text(str, data.settings.margin.left, pageHeight - 10);
	        },
	        margin: {
				top: 70,
	        	bottom: 30,
	        }
	    });
	    
	    doc.save('Subject Mapping List {{ Carbon\Carbon::now()->format('m-d-Y') }}.pdf');
	    history.go(-1);
	</script>
</body>



</html>