# 🤖 Rollout
## By Genericmilk

Rollout allows you to simplify A/B testing by specifying a date of when your code should be fully live in a simple controller if statement! It allows big changes to be rolled out slowly using IP addresses so you can respond quicker to issues before it hits everyones screens!

### Install Rollout
To get started using Rollout you need to add it to your composer.json file. You can do this by running the following command
```
composer require genericmilk/rollout
```
This'll install the prerequisites to get Rollout working.

### Using Rollout
To get started using Rollout in your controller, You need to import it. Add this to the top of your controller to get started;
```
use Genericmilk\Rollout\Rollout;
```
Now that you've added Rollout to your controller, you can use it to in your functions!

### Creating a rollout
Rollouts simply return booleans which allow them to be used in if statements very easily. To create one, simply use the following code:
```
if(Rollout::from('2019-12-12 00:00:00')->until('2019-12-13 20:00:00')->go()){
    return 'Rolling out is pretty fun';
}
```
Rollout will use the `from` parameter and work out how close we are to the `until` parameter. It'll then use that percentage to progress through IP addresses (Starting at 0.0.0.0 all the way up to 255.255.255). If your ip address falls below the current rollout percentage the boolean will return a `false` which will make the code you specify not fire. However if you are within the threshold, the boolean will naturally return a `true` which means you get to run the code specified!

You can do this in a full if/else statement too by extending as such
```
if(Rollout::from('2019-12-12 00:00:00')->until('2019-12-13 20:00:00')->go()){
    return 'Rolling out is pretty fun';
}else{
    return 'Pity you cannot see it until you meet the threshold ;)';
}
```
In the above example the controller will return the appropriate string depending on your current rollout.

### Showing a percentage of a rollout
If you need to see where a rollout is in its lifespan you can instead of using the `->go()` command substitute for `->status();`. This will instead of returning a boolean return a `int` with the curent percentage of the rollout. You can use that like so;
```
$Status = Rollout::from('2019-12-12 00:00:00')->until('2019-12-13 20:00:00')->status();
return 'The rollout is currently at '.$Status.'%';
```

### Roadmap
I really hope you love using Rollout! Let me know your thoughts! I have some improvements down the line too and am open to bug fixes etc. Hope this is useful to you!

Love you guys 🥰
