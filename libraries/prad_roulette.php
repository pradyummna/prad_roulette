<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Prad Roulette
*
* Version: 0.1
*
* Author: Pradyummna Reddy
*		  prad@hireprad.co.uk
*         
*
* Location: https://github.com/pradyummna/prad_roulette
*
* Created:  21/10/2014
*
* Description:  The library can be used for roulette system developers
*
* Requirements: PHP5 or above
*
*/

class Prad_roulette
{
	
	/**
	 *
	 * Function to find if the number is a valid roulette number
	 *
	 * @param  integer  $number The number to which has to be checked
	 *
	 * @return boolean 
	 *
	 * Anchor: 1num
	 */
	 function isValidRouletteNumber($number)
	{
		if(ctype_digit($number) && $number < 37 && $number >= 0 ){return true;}else{return false;}
	}
	
	
	/**
	 * Function to finds the number's color` in a roulette table
	 *
	 * @param  integer  $number The number to which the colour is to be determined
	 *
	 * @return string
	 *
	 * Anchor : 2color
	 */
	function findColour($number)
	{
	
		// checking the input numbers
		if(!($this->isValidRouletteNumber($number))){return 'InValidInput';}
		
		$wheel = array('0','32','15','19','4','21','2','25','17','34','6','27','13','36','11','30','8','23','10','5','24','16','33','1','20','14','31','9','22','18','29','7','28','12','35','3','26');
			
		$numberInArray = array_keys($wheel, $number);
		
		if(isset($numberInArray[0]))
		{
			if($numberInArray[0] == '0')
			{$blackRred='ZERO';}
			else{
					if($numberInArray[0] % 2 == 0)
					{
						//its black!!!
						$blackRred='Black';
					}
					else{ $blackRred = 'Red'; }
				}
		}
		else
		{
			$blackRred = 'OUT';
		}
	
	return $blackRred;	
	}
	
	/**
	 * Function to finds the number's neighbours left to them
	 *
	 * @param  integer  $number The number to which the left neighbours is to be determined
	 * @param  integer  $howManyNeighbours The total neighbours to be found
	 * @return array
	 *
	 * Anchor: neiLside
	 */
	function neighboursLeft($number,$howManyNeighbours)
	{	
		// checking the input numbers
		if(!($this->isValidRouletteNumber($number)) || !($this->isValidRouletteNumber($howManyNeighbours))){return array('InValidInput');}
		
		$x = $howManyNeighbours;
		$wheel = array('0','32','15','19','4','21','2','25','17','34','6','27','13','36','11','30','8','23','10','5','24','16','33','1','20','14','31','9','22','18','29','7','28','12','35','3','26');
		
		$numberInArray = array_keys($wheel, $number);
		
		$neighboursLeft = null;
		if(isset($numberInArray[0]))
		{
			$currentNumber = $numberInArray[0];
			
			//finding the end of the array
			$startValueInArray = reset($wheel);
			//$endArrayKey = key($wheel);				
			//reset($wheel);
				
			//moving to the current position value position in the array
			while (key($wheel) !== $numberInArray[0]) next($wheel);
			
			$neighboursLeft[0] = 'In';
			for($i=0;$i<$x;$i++)
			{
				if(current($wheel) != $startValueInArray)
				{
					//echo next($wheel);echo '::'.$i; echo '<br/>';
					$neighboursLeft[$i+1] =  prev($wheel);
				}
				else
				{
					end($wheel);
					//echo current($wheel);echo '::'.$i;echo '<br/>';
					$neighboursLeft[$i+1] =  current($wheel);
				}
			}
		}
		else
		{
			$neighboursLeft = array('OUT');
		}
		//$neighboursLeft[0] can be OUT or In 
		return $neighboursLeft;
		
	}
	
	/**
	 * Function to finds the number's neighbours right to them
	 *
	 * @param  integer  $number The number to which the right neighbours is to be determined
	 * @param  integer  $howManyNeighbours The total neighbours to be found
	 * @return array
	 *
	 * Anchor: neirside
	 */
	function neighboursRight($number,$howManyNeighbours)
	{
	
		// checking the input numbers
		if(!($this->isValidRouletteNumber($number)) || !($this->isValidRouletteNumber($howManyNeighbours))){return array('InValidInput');}
		
		
		$x = $howManyNeighbours;
		$wheel = array('0','32','15','19','4','21','2','25','17','34','6','27','13','36','11','30','8','23','10','5','24','16','33','1','20','14','31','9','22','18','29','7','28','12','35','3','26');
		
		$numberInArray = array_keys($wheel, $number);
		
		$neighboursRight = null;
		if(isset($numberInArray[0]))
		{
			$currentNumber = $numberInArray[0];
			
			//finding the end of the array
			$endValueInArray = end($wheel);
			//$endArrayKey = key($wheel);				
			reset($wheel);
				
			//moving to the current position value position in the array
			while (key($wheel) !== $numberInArray[0]) next($wheel);
			
			$neighboursRight[0] = 'In';
			for($i=0;$i<$x;$i++)
			{
				if(current($wheel) != $endValueInArray)
				{
					//echo next($wheel);echo '::'.$i; echo '<br/>';
					$neighboursRight[$i+1] =  next($wheel);
				}
				else
				{
					reset($wheel);
					//echo current($wheel);echo '::'.$i;echo '<br/>';
					$neighboursRight[$i+1] =  current($wheel);
				}
			}
				
		}
		else
		{
			$neighboursRight = array('OUT');
		}
		
		// $neighboursRight[0] can be OUT or In
		return $neighboursRight;
		
	}
	
	/**
	 * Function to finds the number's neighbours right to them
	 *
	 * @param  array  $numbers The number to which the right neighbours is to be determined
	 * @param  array  $moneyOnNumbers The total neighbours to be found
	 * @param  integer $winningNumber The winning number
	 * @return array payoutAmount, Profit, Invested amount
	 *
	 * Anchor: xPayoutProfit
	 */
	function payoutProfit($numbers,$moneyOnNumbers,$winningNumber)
	{
		// checking the input numbers
		if(!($this->isValidRouletteNumber($number)) || !($this->isValidRouletteNumber($winningNumber))){return array('InValidInput');}
		
		//find the payout
			
			if(in_array($winningNumber,$numbers))
			{
				$amountOnNumber = $moneyOnNumbers[array_search($winningNumber)];
				$payoutAmount = $amountOnNumber * 36;
			}
			else
			{
				$payoutAmount = 0;
			}			
			$totalInvested = 0;
			
			// find the amount invested on it
			foreach($moneyOnNumbers as $money)
			{
				$totalInvested = $totalInvested + $money;
			}			
			
			//calculate profit
			$profit = $payoutAmount - $totalInvested;
			
			//return
			return array($payoutAmount,$totalInvested,$profit);
	}
}

//1000861505 

/*
1.  Function to check if the number is a valid number or not (input: number | output: true/false) [anchor: 1num]
2.  Function to return a colour based on the given number (input: number | output: colour) [anchor: 2color]
3.  Function to find neighbours on to the right of a given number (input: number, number of neighbours | output: array of numbers) [anchor: neirside]
4.  Function to find neighbours on to the left of a given number (input: number, number of neighbours | output: array of numbers) [anchor: neiLside]
5.  Function to return profit n payoutAmount for the game (input: array(invested numbers), array(amount invested ), winning number | output: array( amountReceivedAtTheEnd, profit, lossAmount, investedAmount)) [anchor: xPayoutProfit]

6.  Function to find xth neighbour on the right (input: number, x | output: number)
7.  Function to find xth neighbour on the left (input: number, x | output: number)
8.  Function to find the neighbour distance right (clock wise) (input: number1, number2 | output: total numbers inbetween)
9.  Function to find the neighbour distance left (Anti clock wise) (input: number1, number2 | output: total numbers inbetween)
10. Function to know which dozen the number belongs to (input: number | output: dozen's number or 0)
11. Function to see if the number is even or odd (input: number | output: even r odd r 0)
12. Function to to find Low1to18OrHigh19to36 (input: winning Number | output: low or high or 0)
13. Function to find the column number 1st 2nd or 3rd (input: winning number | output: column number or 0)
14. Function to return finals(1,11,21,31,2,22,32..) for the number given (input: winning number | output: finals number)
15. Function to return sector of the wheel (input: winning number | output: sector name[zero game, neighbours of zero..])

*/