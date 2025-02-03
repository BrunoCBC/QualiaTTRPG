<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiceController extends Controller
{
    public function index($rpg_hash)
    {
        return view('dice.index', [
            'rpg_hash' => $rpg_hash,
            'dicePresets' => ['d4', 'd6', 'd8', 'd10', 'd20'],
        ]);
    }

    public function roll(Request $request, $rpg_hash)
    {
        $validated = $request->all();

        $rerollCritUp = filter_var($request->input('crit_up_checkbox'), FILTER_VALIDATE_BOOLEAN);
        $rerollCritDown = filter_var($request->input('crit_down_checkbox'), FILTER_VALIDATE_BOOLEAN);
        $countCritUp = filter_var($request->input('count_crit_up_checkbox'), FILTER_VALIDATE_BOOLEAN);
        $countCritDown = filter_var($request->input('count_crit_down_checkbox'), FILTER_VALIDATE_BOOLEAN);

        $diceType = $validated['dice_type'];
        $numDice = $validated['num_dice'];
        $critUp = $validated['crit_up'] ?? null;
        $critDown = $validated['crit_down'] ?? null;

        $critUpCount = 0;
        $critDownCount = 0;
        $rolls = [];
        $rerolled = [];

        for ($i = 0; $i < $numDice; $i++) {
            $roll = rand(1, $diceType);
            $rolls[] = $roll;

            if ($critUp !== null && $roll >= $critUp && $countCritUp) {
                $critUpCount++;
            }
            if ($critDown !== null && $roll <= $critDown && $countCritDown) {
                $critDownCount++;
            }

            if ($rerollCritUp && $critUp !== null && $roll >= $critUp) {
                do {
                    $reroll = rand(1, $diceType);
                    $rerolled[] = $reroll;
                    if ($reroll >= $critUp && $countCritUp) {
                        $critUpCount++;
                    }
                    if ($reroll <= $critDown && $countCritDown) {
                        $critDownCount++;
                    }
                } while ($reroll >= $critUp);            
            }
            
            if ($rerollCritDown && $critDown !== null && $roll <= $critDown) {
                do {
                    $reroll = rand(1, $diceType);
                    $rerolled[] = $reroll;
                    if ($reroll >= $critUp && $countCritUp) {
                        $critUpCount++;
                    }
                    if ($reroll <= $critDown && $countCritDown) {
                        $critDownCount++;
                    }
                } while ($reroll <= $critDown);
            }           
        }

        $allRolls = array_merge($rolls, $rerolled);
        rsort($allRolls);

        $rollCounts = array_count_values($allRolls);
        $maxRepetition = max($rollCounts);
        $mostRepeated = implode(', ', array_keys($rollCounts, $maxRepetition));

        $totalRollBeforeBonus = array_sum($allRolls);
        $totalRollWithBonus = $totalRollBeforeBonus + ($validated['result_bonus'] ?? 0);
        $totalDiceRolledWithBonus = $critUpCount + $critDownCount;

        $critUpActive = $critUp !== null && $countCritUp;
        $critDownActive = $critDown !== null && $countCritDown;
        $rerollUpActive = $rerollCritUp;
        $rerollDownActive = $rerollCritDown;

        return view('dice.result', [
            'rpg_hash' => $rpg_hash,
            'rolls' => $allRolls,
            'total_roll_before_bonus' => $totalRollBeforeBonus,
            'total_roll_with_bonus' => $totalRollWithBonus,
            'total_dice_rolled' => $totalDiceRolledWithBonus,
            'dice_type' => $diceType,
            'crit_up_count' => $critUpCount,
            'crit_down_count' => $critDownCount,
            'num_dice' => $numDice,
            'crit_up' => $critUp,
            'crit_down' => $critDown,
            'crit_up_active' => $critUpActive,
            'crit_down_active' => $critDownActive,
            'reroll_up_active' => $rerollUpActive,
            'reroll_down_active' => $rerollDownActive,
            'highest_repeats' => $mostRepeated,
            'result_bonus' => max(0, $validated['result_bonus'] ?? 0),
            'hits_bonus' => max(0, $validated['hits_bonus'] ?? 0),
        ]);
    }
}
