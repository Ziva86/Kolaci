<?php
//require_once('./core/init.php');

class View
{
    
public function displayCart($array)
	{
		$x=1;
		$total = 0;
		$output = '';
		foreach ($array as $key => $value) {
			$total += $value['qty'] * $value['price'];
			$output .= '<tr>';
			$output .= '<td align="center">' . $x. '</td>';
			$output .= '<td><a href="detail?id=' . $key . '">';
			$output .= '<img src="images/' . $value['link'] . '.jpg" alt="' . $value['title'] . '" width="60" height="60" />';
			$output .= '</a>';
			$output .= '</td>';
			$output .= '<td>' . $value['title'] . '</td>';
			$output .= '<td>Qty: <br />';
			$output .= '<input type="text" value="' . $value['qty'] . '" name="qty['.$key.']" class="s0" size="2" /></td>';
			$output .= '<td align="right">' . sprintf('$ %8.2f', $value['price']) . '</td>';
			$output .= '<td align="right">' . sprintf('$ %8.2f', $value['qty'] * $value['price']) . '</td>';
			$output .= '<td>';
			$output .= '<table>';
			$output .= '<tr>';
			$output .= '<td>Remove</td>';
			$output .= '<td><input type="checkbox" name="remove['.$key.']" value="1" title="Remove" /></td>';
			$output .= '</tr>';
			$output .= '<tr>';
			$output .= '<td>Update</td>';
			$output .= '<td><input type="checkbox" name="update['.$key.']" value="1" title="Update" /></td>';
			$output .= '</tr>';
			$output .= '</table>'; 
			$output .= '</td>';
			$output .= '</tr>';
			$x++;
		}
		
		$output .= '<tr>';
		$output .= '<th colspan="5">Products Total:</th>';
		$output .= '<th colspan="2">' . sprintf('$ %10.2f', $total) . '</th>';
		$output .= '</tr>';
		return $output;
	}
	


    
    public function displayProducts($page,$linesPerPage,$maxProducts,$products)
    {
            $offset=$page*$linesPerPage;
            $output='';			 
            for($x=0; $x<$linesPerPage; $x++)
            {
               if($x+$offset>=$maxProducts)
               {
                    break;
               }
                    $output.='<li>';
                    $output.='<div class="image">';
                    $output.='<a href="detail?id='.$products[$x+$offset]->id.'">';
                    $output.='<img src="images/'
                              .$products[$x+$offset]->link.'.jpg" alt="'.$products[$x+$offset]->title.'" width="190" height="130"/>';
                    $output.='</a>';
                    $output.='</div>';
                    $output.='<div class="detail">';
                    $output.='<p class="name"><a href="detail?id='.$products[$x+$offset]->id.'">'.$products[$x+$offset]->title."</a></p>";
                    $output.='<p class="view"><a href="detail?id='.$products[$x+$offset]->id.'">purchase</a> | <a href="detail?id='.$products[$x+$offset]->id.'">view details >></a></p>';
                    $output.='</div>';
                    $output.='</li>';
            }
        return $output;
    
    }
        public function displayMembers($page,$linesPerPage,$maxMembers,$members)
    {
            $offset=$page*$linesPerPage;
            $output='';			 
            for($x=0; $x<$linesPerPage; $x++)
            {
               if($x+$offset>=$maxMembers)
               {
                    break;
               }
                        $output.='<tr>';
                        $output.='<td>'.$members[$x+$offset]->id.'</td>';
			$output.='<td><img src="images/m.gif" />'.$members[$x+$offset]->first_name." ".$members[$x+$offset]->last_name.'</td>';
			$output.='<td>'.$members[$x+$offset]->city.'</td>';
			$output.='<td><img src="images/e.gif" />'.$members[$x+$offset]->telephone.'</td>';
                        $output.='</tr>';
            }
        return $output;
    
    }
    
    
    
          public function displayDetail($details)
	{
		$output = '';
		$output .= '<div class="images">';
		$output .= '<a href="#">';
		$output .= '<img src="images/' 
				 . $details[0]->link 
				 . '.jpg" alt="'
				 . $details[0]->title
				 . '" width="350" />';
		$output .= '</a>';
		$output .= '</div>';
		$output .= '<div class="details">';
		$output .= '<h3>' . $details[0]->title . '</h3><br/>';
		$output .= '<h1 class="name"><b>' . $details[0]->title . '</b></h1><br/>';
		$output .= '<p class="desc">' . $details[0]->description;
		$output .= '</p>';
		$output .= '<br/>';
		$output .= '<p class="view"><b>Price: ' . sprintf('%8.2f', $details[0]->price) . '</b></p><br/>';
		$output .= '<form action="purchase.php" method="get">';
		$output .= '<p class="view">';
		$output .= '<label>Qty:</label> <input type="text" value="1" name="qty" class="s0" size="2" />';
		$output .= '<input type="submit" name="purchase" value="Buy this item" class="button"/>';
		$output .= '<input type="hidden" name="link" value="' . $details[0]->link . '" />';
		$output .= '<input type="hidden" name="title" value="' . $details[0]->title . '" />';
		$output .= '<input type="hidden" name="price" value="' . $details[0]->price . '" />';
		$output .= '<input type="hidden" name="productID" value="' . $details[0]->id . '" />';
		$output .= '</p>';
		$output .= '</form>';
		$output .= '</div>';
		return $output;		
	}
	
		/*
	 * Produces a search form
	 * @param array $titles = array[product_id] = title [optional]
	 */
	public function searchForm()
	{
		$products=DB::getInstance()->getfields('products',array('id','title','link'));
		$search=$products->results();

		$output = '<form name="search" method="get" action="search.php" id="search">' . PHP_EOL;
		$output .= '<input type="text" value="" name="keyword" class="s0" />' . PHP_EOL;
		
		if ($search) {
			$output .= '<br />' . PHP_EOL;
			$output .= '<select name="title" class="s2">' . PHP_EOL;
			$output .='<option></option>' . PHP_EOL;
			foreach ($search as $title => $value) {
				$output .= sprintf('<option value="%s">%s</option>', $value->id, $value->title);
			}
			$output .= '</select>' . PHP_EOL;
			$output .= '<br />' . PHP_EOL;
		}
		$output .= '<input type="submit" name="search" value="Search Products" class="button marT5" />' . PHP_EOL;
		$output .= '<input type="hidden" name="page" value="search" />' . PHP_EOL;
		$output .= '</form><br /><br />' . PHP_EOL;
		return $output;
	}




}


?>