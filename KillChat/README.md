KillChat
========

Main Authors: EvolSoft

Website:  https://www.evolsoft.tk




 Second development: Praxthisnovcht
 
 
• Added option in the chat Format | CustomJoin


•This Plugin uses the New API. You can't install it on old versions of PocketMine.


•this plugin will not work without CustomChat!


Source : https://github.com/Praxthisnovcht/KillChat




##Features


###### • Kills Counter


###### • Deaths Counter


###### • save without database Players Stats


###### • Depends CustomChat


To use it, you need to read the documentation before asking how it works please.




development and problem with the plugin
•https://github.com/Praxthisnovcht/KillChat/pulls
•https://github.com/Praxthisnovcht/KillChat/issues


Use KillChat in CustomChat




You must first install and install CustomChat KillChat in the Plugins folder.

Start your server and it is not over xD




CustomChat Open the folder in your plugins folder and then open the config.yml







You will find this


**Configuration (config.yml):**
```yaml
---
chat-format: '{WORLD_NAME}:[{FACTION}][{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'

if-player-has-no-faction: NoFaction

enable-formatter: true

disablechat: false

default-player-prefix: Default

CustomChat options: '{Kills} | {Deaths} | {Money}'

if-player-has-no-job: unemployed

Enable Support Money: false

CustomJoin: '@player joined the server ! Isaku is Awesome'

CustomLeave: '@player leave the server ! Isaku is Awesome'
...

```

The only important thing is to set KillChat


**Configuration (config.yml):**
```yaml
---
chat-format: '{WORLD_NAME}:[{FACTION}][{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'

if-player-has-no-faction: NoFaction

enable-formatter: true

disablechat: false

default-player-prefix: Default

CustomChat options: '{Kills} | {Deaths} | {Money}'

if-player-has-no-job: unemployed

Enable Support Money: false

CustomJoin: '@player joined the server ! Isaku is Awesome'

CustomLeave: '@player leave the server ! Isaku is Awesome'
...

```


###### only is this line can be changed.


###### This is not to say the other lines removed!


You want to add the counter KillChat discution the room?


very simple!


Just add this

**Configuration (config.yml):**
```yaml
---
{Kills} # Indicating the person you have killed scores

{Deaths} # Indicating the number of times you are dead[/PHP]

# Now you'll add it to the Chat-Format line

chat-format: '{WORLD_NAME}:[{FACTION}][{PurePerms}][{PREFIX}]<{DISPLAY_NAME}>[{Kills}]|[{Deaths}] {MESSAGE}'

After you removed the Chat-Format elements to overload length.

You also put it where you want to use tags to well specified



CustomJoin: '@player joined the server ! Isaku is Awesome'

CustomLeave: '@player leave the server ! Isaku is Awesome'

...

```





The elements to insert are

**Configuration (config.yml):**
```yaml
---

@Player

@Faction

@PurePerms

@Kills

@Deaths

...

```

Then to add here:

it is possible to add any options but it will overload the discution.


```yaml
---

CustomJoin: '@player joined the server ! Isaku is Awesome'

CustomLeave: '@player leave the server ! [@Kills]|[@Deaths]'

...

```



## and He is ready to use!

