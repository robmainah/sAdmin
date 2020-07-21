<html>
	<head>
		<title>SHOPIT E-COMMERCE SYSTEMS</title>
		<style type="text/css">
			table {
				width: 100%;
				font-family: Helvetica, Arial, Sans-serif;
				/*border: 1px solid black;*/
				border-collapse: collapse;
			}
			td {
				padding: 8px;
				border: 1px solid black;
				font-size: 12px;
			}
			th {
				padding: 8px;
				font-size: 12px;
				border: 1px solid black;
				background-color: #54bbc8cc;
			}
			.st {
				padding: 10px;
			}
			table tr:nth-of-type(2n+2)
			{
				background-color: #e6e6e6;
			}
		</style>
	</head>

	<body>
		<h2 style="text-align: center;">SHOPIT E-COMMERCE SYSTEMS</h2>
		<h4 style="text-align: center;">Products Report</h4>
		<table class="table table-striped table-bordered table-hover tbl_employees" id="dataTables-example">
		    <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price (KSH )</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $product->title }}</td>
                        <td>
                            @if ($product->category)
                                {{ $product->category->cat_name }}
                            @else
                                <span class="text-danger">Deleted</span>
                            @endif
                        </td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->created_by }}</td>
                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
		</table>
	</body>
</html>
