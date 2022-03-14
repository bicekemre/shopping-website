<?php
if ($_SESSION["User"]){

    $RightandLeftButtonCountforPagination		=	2;
    $ViewingDataCountinperPage		            =	10;
    $Query				                        =	$DatabaseConnect->prepare("SELECT * FROM favorites WHERE UserId = ? ORDER BY id DESC");
    $Query->execute([$UserID]);
    $Query				                        =	$Query->rowCount();
    $offset		                                =	($Pagination*$ViewingDataCountinperPage)-$ViewingDataCountinperPage;
    $PageCount					                =	ceil($Query/$ViewingDataCountinperPage);
    ?>
    <table width="1065" bgcolor="#f0e68c" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3"><hr /></td>
        </tr>
        <tr>
            <td colspan="3"><table width="1065"  align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="203" bgcolor="#b8860b" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?PageCode=45" style="text-decoration: none; color: black;">Account Information</a></td>
                        <td width="10">&nbsp;</td>
                        <td width="203"  bgcolor="#b8860b" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?PageCode=53" style="text-decoration: none; color: black;">Address</a></td>
                        <td width="10">&nbsp;</td>
                        <td width="203"  bgcolor="#b8860b" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?PageCode=54" style="text-decoration: none; color: black;">Favorites</a></td>
                        <td width="10">&nbsp;</td>
                        <td width="203"  bgcolor="#b8860b" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?PageCode=55" style="text-decoration: none; color: black;">Comments</a></td>
                        <td width="10">&nbsp;</td>
                        <td width="203"  bgcolor="#b8860b" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?PageCode=56" style="text-decoration: none; color: black;">Orders</a></td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td colspan="3"><hr /></td>
        </tr>
        <tr>
            <td width="500" valign="top">
        <tr align="center" height="40">
            <td style="color:black"><h3>My Account > Favorites</h3></td>
        </tr>
        <tr height="30">
            <td valign="top" align="center" style="border-bottom: 1px dashed #CCCCCC;">You Can see your Favorites.</td>
        </tr>
        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="50">
                <td width="75" style="background: #f8ffa7; color: black;" align="left">&nbsp;Picture</td>
                <td width="75" style="background: #f8ffa7; color: black;" align="left">Delete</td>
                <td width="865" style="background: #f8ffa7; color: black;" align="left">Item Name</td>
                <td width="100" style="background: #f8ffa7; color: black;" align="left">Price</td>
            </tr>
            <?php
            $FavoritesQuery		    =	$DatabaseConnect->prepare("SELECT * FROM favorites WHERE UserId = ? ORDER BY id DESC LIMIT $offset, $ViewingDataCountinperPage");
            $FavoritesQuery->execute([$UserID]);
            $FavoritesCount			=	$FavoritesQuery->rowCount();
            $FavoritesRecords 	        =	$FavoritesQuery->fetchAll(PDO::FETCH_ASSOC);

            if($FavoritesCount>0){
                foreach($FavoritesRecords as $Lines){
                    $ItemQuery		=	$DatabaseConnect->prepare("SELECT * FROM items WHERE id = ? LIMIT 1");
                    $ItemQuery->execute([$Lines["ItemID"]]);
                    $ItemRecords			=	$ItemQuery->fetch(PDO::FETCH_ASSOC);

                    $ItemName			=	$ItemRecords["ItemName"];
                    $ItemType		    =	$ItemRecords["ItemType"];
                    $ItemPic		    =	$ItemRecords["ItemPicOne"];
                    $ItemPrice	        =	$ItemRecords["ItemPrice"];
                    $ItemCurrency	=	$ItemRecords["Currency"];

                    if($ItemType == "Phone"){
                        $PicturePath	=	"Phone";
                    }elseif($ItemType == "Computer"){
                        $PicturePath	=	"Computer";
                    }

                    ?>
                    <tr height="30">
                        <td width="75" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?PageCode=77&ID=<?php echo Safety($ItemRecords["id"]); ?>"><img src="Images/ItemPictures/<?php echo $PicturePath; ?>/<?php echo Safety($ItemPic); ?>" border="0" width="60" height="80"></a></td>
                        <td width="50" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?PageCode=75&ID=<?php echo Safety($Lines["id"]); ?>"><img src="Images/Sil20x20.png" border="0"></a></td>
                        <td width="415" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?PageCode=77&ID=<?php echo Safety($ItemRecords["id"]); ?>" style="color: #646464; text-decoration: none;"><?php echo Safety($ItemName); ?></a></td>
                        <td width="100" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?PageCode=77&ID=<?php echo Safety($ItemRecords["id"]); ?>" style="color: #646464; text-decoration: none;"><?php echo PriceFormat(Safety($ItemPrice)); ?> <?php echo Safety($ItemCurrency); ?></a></td>
                    </tr>
                    <?php
                }

                if($PageCount>1){
                    ?>
                    <tr height="50">
                        <td colspan="8" align="center"><div class="PaginationArea">
                                <div class="PaginationTextArea">
                                    Total Records :<?php echo $PageCount; ?> per page <?php echo $Query; ?>
                                </div>

                                <div class="PaginationNumberArea">
                                    <?php
                                    if($Pagination>1){
                                        echo "<span class='PaginationPasive'><a href='index.php?PageCode=54&Page=1'><<</a></span>";
                                        $OneStepBack	=	$Pagination-1;
                                        echo "<span class='PaginationPasive'><a href='index.php?PageCode=54&Page=" . $OneStepBack . "'><</a></span>";
                                    }

                                    for($PageIndexValue=$Pagination-$RightandLeftButtonCountforPagination; $PageIndexValue<=$Pagination+$RightandLeftButtonCountforPagination; $PageIndexValue++){
                                        if(($PageIndexValue>0) and ($PageIndexValue<=$PageCount)){
                                            if($Pagination==$PageIndexValue){
                                                echo "<span class='PaginationActive'>" . $PageIndexValue . "</span>";
                                            }else{
                                                echo "<span class='PaginationPasive'><a href='index.php?PageCode=54&Page=" . $PageIndexValue . "'> " . $PageIndexValue . "</a></span>";
                                            }
                                        }
                                    }

                                    if($Pagination!=$PageCount){
                                        $OneStepForward	=	$Pagination+1;
                                        echo "<span class='PaginationPasive'><a href='index.php?PageCode=54&Page=" . $OneStepForward . "'>></a></span>";
                                        echo "<span class='PaginationPasive'><a href='index.php?PageCode=54&Page=" . $PageCount . "'>>></a></span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr height="50">
                    <td colspan="8" align="left">You have not any Favorite Item</td>
                </tr>
                <?php
            }
            ?>
        </table>
        </td>
        </tr>
    </table>
    <?php
}else{
    header("Location:index.php");
    exit();
}
?>