# eMAG’s Hero - problema test tehnic  
Acest repository reprezinta solutia mea la problema enuntata mai jos.  

# Despre solutia aleasa  
Pentru a crea un sistem flexibil care sa permita cu usurinta adaugarea de noi skilluri am folosit Observer pattern prin  
intermediul componentei Symfony/EventDispatcher.  

Skill-urile se declanseaza in momente cheie ale jocului. In acest moment sunt doar doua evenimente generate de componenta  
EventDispatcher:  play_attack.after respectiv damage.computed  
- play_attack.after  - este un eveniment care se declanseaza dupa terminarea unui atac  
- damage.computed  - este un eveniment care se declanseaza dupa ce damage-ul a fost calculat  


Skill-urile sunt de doua tipuri: atac/defensiva pentru a fi executate de jucator in functie de situatia in care se afla  
in acel moment al jocului (in atac sau in defensiva).  

Adaugare skill:  
- se adauga in fisierul config.php parametrii acestui skill in sectiunea attacking/defensive skill a unui jucator  
- se conecteaza skill-ul la un eveniment din joc prin implementarea efectiva a unor actiuni intr-un EventSubscriber  

De ex: Magic shield  
Dupa ce a fost calculat damage-ul se emite evenimentul "damage.computed".  
Clasa DamageComputedSubscriber este abonata la acest eveniment iar daca jucatorul aflat in defensiva poseda skill-ul  
"Magic shield" - functia magicShieldSkill() este executata operand modificari asupra valorii damage calculate initial  


# Enunt problema:
### The story

Once upon a time there was a great hero, called Orderus, with some strengs and weaknesses, as all heroes have.  
After battling all kinds of monsters for more than a hundred years, Orderus now has the following stats:  

Health : 70 - 100  
Strenght: 70 - 80  
Defence: 45 - 55  
Speed: 40 - 50  
Luck 10% - 30% ( 0% means no luck, 100% lucky all the time).  
Also, he possesses 2 skills:  

Rapid strike: Strike twice while it's his turn to attack, there's a 10% he'll use this skill every time he attacks  
Magic shield: takes only half of the usual damage when an enemy attacks, there's a 20% change he'll use this skill every time he defends.  
### Gameplay
As Orderus walks the ever-green forest of Emagia, he encounters some wild beasts, with the following properties:  

Health: 60 - 90  
Strenght: 60 - 90  
Defence: 40- 60  
Speed: 40 - 60  
Luck: 25% - 40  
You'll have to simulate a battle between Orderus and a wild beast, either at command line or using a web browser. On every battle, Orderus and the beast must be   initialized with random properties, within their ranges.  
The first attack is done by the player with the higher speed. If both players have the same speed, then the attack is carried on by the player with the highest   luck. After an attack, the players switch roles: the attacker now defends and the defender now attacks.  
The damage done by the attacker is calculated with the following formula:  

Damage = Attacker strength -Defender defence  

The damage is subtracted from the defender's health. An attacker can miss their hit and do no damage if the defender gets lucky that turn.  
Orderus' skill occurs randomly, based on their chances, so take them into account on each turn.  

### Game over
The game ends when one of the players remain without health or the number of turns reaches 20.  
The application must output the results each turn: what happens , which skills were used ( if any ), the damage done, defender's health left.  
If we have a winner before the maximum number of rounds is reached, he must be declared.  

### Rules
Emagia is a land where magic dose happen. Still, for this magic to work, you'll have to follow these rules:  

Write code in plain PHP. whiteout any frameworks (you are free to use 3rd parties like PHPUnit, UI libs / frameworks)  
Make sure your application is decoupled, code reusable and scalable. For example, can a new skill easily be added to our hero ?  
Is your code bug-free and tested ?  
There's no time limit, take your time for the best approach you can think of.  


# Rulare aplicatie
Exemplu rulare joc:   

$ cd /path_to_files/src  
$ php HeroGame.php  

 Game is on!  
 Players initial stats:  
 Player type: HERO  
Health:      81  
Strength:    99  
Defence:     46  
Speed:       50  
Luck:        29  
Attacking skills:  rapid_strike  
Defensive skills:  rapid_strike  

 Player type: BEAST  
Health:      61  
Strength:    87  
Defence:     56  
Speed:       53  
Luck:        36  
Attacking skills:  dummy_strike  
Defensive skills:  dummy_strike  

 First attacking player: BEAST with speed: 53  
 Current round: 1  
 Defending player: HERO was lucky! No damage occurred!  
 Silly dummy skill is used by attacking player: BEAST but it has no real power  
 Current round: 2  
 Defending player: BEAST was lucky! No damage occurred!  
 Rapid skill is used by attacking player: HERO to launch a second attack per round  
 Defending player: BEAST was lucky! No damage occurred!  
 Current round: 3  
 Attacking player: BEAST strength is: 87.  
 Defending player: HERO health is: 81.  
 Defending player: HERO suffered damage: 6!  
 Defending player: HERO health after damage: 75!  
 Silly dummy skill is used by attacking player: BEAST but it has no real power  
 Current round: 4  
 Defending player: BEAST was lucky! No damage occurred!  
 Unlucky attacking player HERO was not able to use his skill rapid_strike due to bad luck  
 Current round: 5  
 Attacking player: BEAST strength is: 87.  
 Defending player: HERO health is: 75.  
 Defending player: HERO suffered damage: 12!  
 Defending player: HERO health after damage: 63!  
 Silly dummy skill is used by attacking player: BEAST but it has no real power   
 Current round: 6   
 Attacking player: HERO strength is: 99.   
 Defending player: BEAST health is: 61.   
 Defending player: BEAST suffered damage: 38!  
 Defending player: BEAST health after damage: 23!  
 Unlucky attacking player HERO was not able to use his skill rapid_strike due to bad luck  
 Current round: 7  
 Attacking player: BEAST strength is: 87.  
 Defending player: HERO health is: 63.  
 Defending player: HERO suffered damage: 24!   
 Defending player: HERO health after damage: 39!  
 Silly dummy skill is used by attacking player: BEAST but it has no real power   
 Current round: 8   
 Defending player: BEAST was lucky! No damage occurred!   
 Rapid skill is used by attacking player: HERO to launch a second attack per round  
 Defending player: BEAST was lucky! No damage occurred!  
 Current round: 9  
 Attacking player: BEAST strength is: 87.  
 Defending player: HERO health is: 39.  
 Defending player: HERO suffered damage: 48!  
 Defending player: HERO health after damage: -9!  
 Silly dummy skill is used by attacking player: BEAST but it has no real power  
 End of the game, player HERO remained without health!  
 Winner : BEAST  
 GAME OVER!  
