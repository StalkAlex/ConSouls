### ConSouls

**ConSouls** is a command line based fantasy RPG, where players must battle monsters in a dark fictional world - console :) Inspired by Dark Souls game series.

Prepare to die lots of times, fighting monsters over and over before you know their habits well enough. Listen carefully, because a monster's growl is the key to the victory, it is unique for its every move.

Since this version of game is MVP, I have implemented the following functions: profile registration, fighting and game saving.

- **Profile registration.** It is mandatory that a user has at least one existing profile before playing. To create a profile you use ```rpg:create_profile``` command. Then you have to type your profile name and choose a class. There are two example classes in this version: a Mage and a Knight. Each class has its own characteristics.

- **Fighting.** After registration the profile user can start to play, using ```rpg:game``` command. This version contains one example monster that fights the player. It attacks first, and the player can choose from two example commands to confront: blocking and rolling. The monster has several kinds of its attack, each of them needs its own way of confrontation; the player has to guess which one. The player’s attack is activated automatically in case of a successful repelling an enemy’s hit. After each attack the fighting stats are shown. The player gets a level up when killing a monster.
  - Attacks of the current monster: 
    - Grasp. This is a rollable attack. The sound is 'Grrrrr'. To deal a damage to the monster player has to roll.
    - Sword attack. This atack can be confronted by both rolling or blocking. The sound for this attack is 'Arghhh'.
    - Fire storm. This one is a tricky attack, it's undefendable, because you can't be absolutely safe in this game :) The sound is 'Bams'. This action set is balanced, so the player can win the fight successfully defending two other attacks.

- **Saving the game.** The game is saved automatically after the player wins a fight. Also, it's loaded automatically when the player enters the game.

The project is designed with the possibility of extending the functionality. More classes, monsters, attack, defense and weapon types can be added. Also, players will be able to collect loot from the monsters. The damage calculation method can be changed as well.

P.S. To play a game please apply migrations ```doctrine:schema:update --force```

