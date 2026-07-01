<?php

declare(strict_types=1);

if (! function_exists('bsh_faq_topics')) {
    function bsh_faq_topics(): array
    {
        return [
            [
                'id' => 'ablauf-einzeltraining',
                'nav_label' => 'Ablauf des Einzeltrainings',
                'title' => 'So läuft Einzeltraining in Hamburg ab',
                'intro' => [
                    'Im Einzeltraining schauen wir nicht nur auf ein einzelnes unerwünschtes Verhalten. Wir betrachten die konkrete Situation, mögliche Auslöser, eure bisherigen Erfahrungen und die Bedingungen, unter denen das Verhalten auftritt.',
                    'Daraus entwickeln wir einen Trainingsweg, der zu eurem Alltag, eurem Tempo und euren Möglichkeiten passt. Du bekommst keine abstrakten Standardratschläge, sondern nachvollziehbare Schritte, die du zwischen den Terminen umsetzen und überprüfen kannst.',
                    'Je nach Thema kann ein ausführliches Erstgespräch der sinnvollste Einstieg sein. Das gilt besonders bei komplexen Verhaltensproblemen, plötzlichen Veränderungen, bekannten Beißvorfällen oder wenn gesundheitliche Ursachen nicht ausgeschlossen sind.',
                ],
                'steps' => [
                    'Situation beobachten',
                    'Verhalten und Zusammenhänge einordnen',
                    'Ein realistisches Ziel definieren',
                    'Konkrete Schritte für den Alltag entwickeln',
                    'Fortschritte und Rückschritte gemeinsam auswerten',
                ],
                'questions' => [
                    [
                        'question' => 'Warum wird die Situation zuerst beobachtet?',
                        'answer' => [
                            'Ein Verhalten lässt sich nur sinnvoll einordnen, wenn wir wissen, wann, wo und unter welchen Bedingungen es auftritt. Deshalb betrachten wir nicht nur das sichtbare Verhalten deines Hundes, sondern auch die Umgebung, Abstände, Bewegungen, beteiligte Menschen oder Hunde und deine bisherigen Reaktionen.',
                            'Die Beobachtung hilft dabei, vorschnelle Bewertungen zu vermeiden. Ein Hund, der an der Leine bellt, kann beispielsweise aufgeregt, unsicher, frustriert, überfordert oder körperlich beeinträchtigt sein. Von außen kann das Verhalten ähnlich aussehen, obwohl unterschiedliche Trainingsansätze nötig sind.',
                        ],
                    ],
                    [
                        'question' => 'Muss das problematische Verhalten im Training provoziert werden?',
                        'answer' => [
                            'Nein. Wir stellen keine Situation absichtlich so her, dass dein Hund überfordert wird oder Menschen und Tiere gefährdet werden.',
                            'Wenn eine direkte Beobachtung nicht sicher oder sinnvoll möglich ist, arbeiten wir zunächst mit deiner Beschreibung, vorhandenen Videoaufnahmen und kontrollierten Trainingssituationen. Abstand und gutes Management sind dabei kein Ausweichen, sondern schaffen häufig erst die Voraussetzungen für Lernen.',
                        ],
                    ],
                    [
                        'question' => 'Was sollte ich vor dem Termin dokumentieren?',
                        'answer' => [
                            'Hilfreich sind kurze, möglichst sachliche Notizen:',
                            '<ul><li>Was ist unmittelbar vor dem Verhalten passiert?</li><li>Wo fand die Situation statt?</li><li>Wer oder was war beteiligt?</li><li>Wie groß war der Abstand zum Auslöser?</li><li>Wie hat sich dein Hund vorher und nachher verhalten?</li><li>Wie hast du reagiert?</li><li>Wie lange dauerte es, bis dein Hund wieder ruhig und ansprechbar war?</li><li>Tritt das Verhalten immer oder nur unter bestimmten Bedingungen auf?</li></ul>',
                            'Kurze Videos können zusätzlich helfen, sofern sie ohne Risiko aufgenommen werden können. Gefährliche Situationen sollen niemals nur für eine Aufnahme wiederholt werden.',
                        ],
                    ],
                    [
                        'question' => 'Was bedeutet es, Verhalten einzuordnen?',
                        'answer' => [
                            'Wir betrachten Verhalten nicht isoliert als „richtig“ oder „falsch“. Stattdessen prüfen wir, welche Funktion es in der jeweiligen Situation haben könnte und welche Faktoren es wahrscheinlicher machen.',
                            'Dazu können Angst oder Unsicherheit, Frustration, hohe Erregung, fehlende Lernerfahrung, Schmerzen, ungünstige Abstände, Überforderung durch Umweltreize oder unbeabsichtigte Verstärkung im Alltag gehören. Diese Einordnung ist die Grundlage dafür, geeignete Trainings- und Managementmaßnahmen auszuwählen.',
                        ],
                    ],
                    [
                        'question' => 'Wie wird aus der Einordnung ein realistisches Ziel?',
                        'answer' => [
                            'Ein klares Ziel macht Fortschritte sichtbar und hilft, passende Übungen auszuwählen. Aussagen wie „Mein Hund soll besser hören“ oder „Er soll nicht mehr ausrasten“ sind verständlich, aber für einen Trainingsplan noch zu ungenau.',
                            'Gemeinsam übersetzen wir den Wunsch in beobachtbares Verhalten. Große Ziele werden in erreichbare Zwischenziele aufgeteilt. So muss der Hund nicht sofort die schwierigste Alltagssituation bewältigen und ihr bleibt handlungsfähig.',
                        ],
                    ],
                ],
                'cta_label' => 'Einzeltraining anfragen',
                'cta_url' => '/kontakt/',
            ],
            [
                'id' => 'leinenfuehrigkeit',
                'nav_label' => 'Leinenführigkeit',
                'title' => 'Leinenführigkeit',
                'intro' => [
                    'Leinenführigkeit bedeutet nicht, dass dein Hund während des gesamten Spaziergangs eng neben dir laufen muss. Vielmehr lernt er, sich an dir zu orientieren und sich auch bei Umweltreizen an lockerer Leine zu bewegen.',
                    'Draußen im Hamburger Alltag wirken oft deutlich mehr Reize auf einen Hund ein als in einer ruhigen Umgebung. Deshalb schauen wir im Einzeltraining nicht nur auf das Ziehen an der Leine, sondern auch auf Umfeld, Tempo und Motivation.',
                ],
                'questions' => [
                    [
                        'question' => 'Warum zieht mein Hund draußen stärker als in ruhiger Umgebung?',
                        'answer' => [
                            'Auf einer ruhigen Fläche kann dein Hund sich leichter orientieren. Im Kiez wirken Gerüche, Menschen, Verkehr, andere Hunde und enge Wege gleichzeitig auf ihn ein. Dadurch steigt häufig die Erregung und bereits gelerntes Verhalten ist schwerer abrufbar.',
                            'Das Ziehen an der Leine kann dann viele Ursachen haben. Manche Hunde wollen schnell zu einem Reiz, andere sind aufgeregt, unsicher, überfordert oder haben noch nicht verstanden, welches Verhalten an der Leine erwünscht ist.',
                        ],
                    ],
                    [
                        'question' => 'Bedeutet Leinenführigkeit, dass mein Hund ständig neben mir laufen muss?',
                        'answer' => [
                            'Nein. Ein entspannter Spaziergang braucht Bewegungsfreiheit. Dein Hund darf schnüffeln, die Umgebung wahrnehmen und sich in einem vereinbarten Rahmen bewegen.',
                            'Das Ziel ist eine lockere Leine und eine verlässliche Orientierung - nicht dauerhaftes Fußlaufen.',
                        ],
                    ],
                    [
                        'question' => 'Wie wird Leinenführigkeit trainiert?',
                        'answer' => [
                            'Wir bauen Orientierung und Kooperation schrittweise auf. Dabei wird erwünschtes Verhalten gezielt bestätigt und zunächst in einer möglichst reizarmen Umgebung geübt.',
                            'Je sicherer dein Hund die Grundlagen beherrscht, desto anspruchsvoller können die Trainingssituationen werden. Ablenkungen, Begegnungen und unterschiedliche Orte werden kontrolliert und in einem Tempo integriert, das dein Hund bewältigen kann.',
                        ],
                    ],
                    [
                        'question' => 'Wie lange dauert es, bis mein Hund an lockerer Leine läuft?',
                        'answer' => [
                            'Das hängt unter anderem vom Alter, Temperament, bisherigen Lernverlauf und Erregungsniveau des Hundes ab. Auch die Häufigkeit und Konsequenz des Trainings spielen eine wichtige Rolle.',
                            'Erste Verbesserungen sind häufig schnell erkennbar. Damit das Verhalten auch bei Ablenkung zuverlässig funktioniert, braucht es jedoch regelmäßiges Training und realistische Zwischenschritte.',
                        ],
                    ],
                    [
                        'question' => 'Welche Ausrüstung ist für das Training sinnvoll?',
                        'answer' => [
                            'Die Ausrüstung sollte sicher sitzen, zur körperlichen Situation des Hundes passen und eine ruhige Führung ermöglichen. Je nach Hund können ein gut sitzendes Geschirr, ein geeignetes Halsband oder eine Kombination sinnvoll sein.',
                            'Welche Lösung zu euch passt, besprechen wir individuell. Hilfsmittel ersetzen dabei niemals den systematischen Trainingsaufbau.',
                        ],
                    ],
                    [
                        'question' => 'Hilft mehr Druck an der Leine?',
                        'answer' => [
                            'Mehr Druck löst die eigentliche Ursache nicht. Wir arbeiten daran, Orientierung, Verständlichkeit und die Rahmenbedingungen so zu verbessern, dass dein Hund ansprechbarer wird und lockere Leine lernen kann.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'alleinbleiben',
                'nav_label' => 'Alleinbleiben',
                'title' => 'Alleinbleiben',
                'intro' => [
                    'Das Alleinbleiben sollte kleinschrittig aufgebaut werden. Der Hund lernt zunächst, dass kurze räumliche Trennungen ungefährlich sind und seine Bezugsperson zuverlässig zurückkehrt.',
                    'Die Dauer wird erst verlängert, wenn der Hund während des vorherigen Trainingsschritts tatsächlich entspannt bleiben konnte. Entscheidend ist nicht, wie lange die Tür geschlossen war, sondern wie sich der Hund dabei gefühlt hat.',
                ],
                'questions' => [
                    [
                        'question' => 'Woran erkenne ich Trennungsstress?',
                        'answer' => [
                            'Mögliche Hinweise sind anhaltendes Bellen oder Jaulen, starkes Hecheln oder Speicheln, Unruhe und ständiges Umherlaufen, Kratzen an Türen oder Fenstern, Zerstören von Gegenständen, Unsauberkeit, Futterverweigerung sowie Erstarren oder ungewöhnlich passives Verhalten.',
                            'Nicht jeder Hund zeigt Trennungsstress laut oder offensichtlich. Eine Kameraaufnahme kann helfen, das Verhalten während der Abwesenheit genauer einzuschätzen.',
                        ],
                    ],
                    [
                        'question' => 'Soll ich meinen Hund einfach bellen lassen, bis er sich beruhigt?',
                        'answer' => [
                            'Nein. Wenn ein Hund aus Angst oder starkem Stress bellt, lernt er durch langes Aushalten nicht automatisch, dass Alleinsein sicher ist. Stattdessen kann sich die negative Erfahrung weiter festigen.',
                            'Das Training sollte so gestaltet werden, dass der Hund möglichst nicht regelmäßig über seine Belastungsgrenze hinausgerät.',
                        ],
                    ],
                    [
                        'question' => 'Wie schnell darf ich die Dauer steigern?',
                        'answer' => [
                            'Die Trainingsschritte richten sich nach dem Verhalten des Hundes. Bei manchen Hunden kann die Dauer relativ zügig gesteigert werden. Andere benötigen zunächst viele sehr kurze Wiederholungen.',
                            'Zu große Zeitsprünge führen häufig zu Rückschritten. Deshalb entwickeln wir einen individuellen Trainingsplan und überprüfen regelmäßig, ob die gewählte Schwierigkeit noch passend ist.',
                        ],
                    ],
                    [
                        'question' => 'Wie lange darf ein Hund allein bleiben?',
                        'answer' => [
                            'Hierfür gibt es keine pauschale Dauer, die für jeden Hund geeignet ist. Alter, Gesundheitszustand, Trainingserfahrung und individuelle Stressanfälligkeit müssen berücksichtigt werden.',
                            'Ein ganzer Arbeitstag ohne Betreuung ist für viele Hunde nicht angemessen. Bei längeren Abwesenheiten sollte frühzeitig eine zuverlässige Betreuung oder Gassihilfe organisiert werden.',
                        ],
                    ],
                    [
                        'question' => 'Wann sollte ich professionelle Unterstützung suchen?',
                        'answer' => [
                            'Professionelle Hilfe ist besonders sinnvoll, wenn dein Hund deutliche Panikreaktionen zeigt, sich selbst gefährdet, Gegenstände zerstört oder bereits bei sehr kurzen Trennungen stark gestresst ist.',
                            'Bei schweren oder plötzlich auftretenden Problemen kann zusätzlich eine tierärztliche beziehungsweise verhaltensmedizinische Abklärung erforderlich sein.',
                        ],
                    ],
                    [
                        'question' => 'Kann ich das Alleinbleiben mit Freilauf im Zuhause verwechseln?',
                        'answer' => [
                            'Nein. Ein Hund, der im selben Raum entspannt ruht, kann trotzdem Probleme haben, wenn echte Trennung oder längere Abwesenheit dazukommt. Deshalb trainieren wir die Situation gezielt und nicht nur nebenbei.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'grenzen-setzen',
                'nav_label' => 'Grenzen setzen',
                'title' => 'Grenzen setzen',
                'intro' => [
                    'Ja. Klare und verlässliche Regeln helfen einem Hund, sich im Alltag zu orientieren. Grenzen sollten jedoch verständlich, fair und vorhersehbar sein.',
                    'Es geht nicht darum, den Hund einzuschüchtern oder ständig zu kontrollieren. Sinnvolle Grenzen schaffen Sicherheit und zeigen dem Hund, welches Verhalten in einer Situation erwünscht ist.',
                ],
                'questions' => [
                    [
                        'question' => 'Wie setze ich Grenzen, ohne meinen Hund zu bestrafen?',
                        'answer' => [
                            'Eine Grenze besteht nicht nur aus einem „Nein“. Der Hund sollte möglichst lernen, was er stattdessen tun kann.',
                            'Dazu gehören beispielsweise unerwünschtes Verhalten frühzeitig erkennen, die Situation ruhig unterbrechen, eine verständliche Alternative anbieten, erwünschtes Verhalten bestätigen und Regeln im Alltag konsequent sowie verlässlich umsetzen.',
                        ],
                    ],
                    [
                        'question' => 'Muss ich mich gegenüber meinem Hund durchsetzen?',
                        'answer' => [
                            'Ein vertrauensvolles Zusammenleben entsteht nicht durch körperliche Überlegenheit oder ständige Machtdemonstrationen. Hunde lernen durch Erfahrungen, Konsequenzen, Wiederholungen und klare Kommunikation.',
                            'Gute Führung bedeutet, Verantwortung zu übernehmen, Situationen vorausschauend zu gestalten und dem Hund Orientierung zu geben.',
                        ],
                    ],
                    [
                        'question' => 'Warum akzeptiert mein Hund Regeln manchmal und manchmal nicht?',
                        'answer' => [
                            'Hunde übertragen Gelerntes nicht automatisch auf jede Situation. Ein Verhalten, das zu Hause funktioniert, kann draußen unter Ablenkung deutlich schwieriger sein.',
                            'Auch Müdigkeit, Stress, Aufregung, Schmerzen oder eine zu schwierige Umgebung können die Kooperationsfähigkeit beeinflussen. Deshalb sollten Regeln schrittweise in unterschiedlichen Situationen trainiert werden.',
                        ],
                    ],
                    [
                        'question' => 'Müssen alle Familienmitglieder dieselben Regeln anwenden?',
                        'answer' => [
                            'Grundsätzlich ja. Unterschiedliche Signale und widersprüchliche Erwartungen können es dem Hund unnötig schwer machen.',
                            'Das bedeutet nicht, dass jede Person exakt gleich mit dem Hund umgehen muss. Die zentralen Regeln, Signale und Konsequenzen sollten jedoch gemeinsam festgelegt und möglichst einheitlich umgesetzt werden.',
                        ],
                    ],
                    [
                        'question' => 'Wie erkenne ich, ob eine Grenze fair ist?',
                        'answer' => [
                            'Fair ist eine Grenze dann, wenn dein Hund verstehen kann, was gemeint ist, und wenn sie zumutbar bleibt. Orientierung, Wiederholung und Klarheit sind wichtiger als Härte.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'angespannte-spaziergaenge',
                'nav_label' => 'Angespannte Spaziergänge',
                'title' => 'Angespannte Spaziergänge',
                'intro' => [
                    'Angespannte Spaziergänge können durch viele Faktoren entstehen. Dazu gehören unter anderem starkes Ziehen an der Leine, Unsicherheit oder Angst, häufige Hundebegegnungen, Jagdverhalten, territoriales Verhalten, hohe Erregung, schlechte Erfahrungen, Schmerzen oder eine für den Hund zu reizintensive Umgebung.',
                    'Gerade in Hamburg treffen auf einer kurzen Runde oft viele Reize gleichzeitig zusammen. Im Training betrachten wir deshalb den gesamten Spaziergang und nicht nur einzelne unerwünschte Verhaltensweisen.',
                ],
                'questions' => [
                    [
                        'question' => 'Warum fühlen sich Spaziergänge mit meinem Hund so anstrengend an?',
                        'answer' => [
                            'Oft ist nicht nur ein einzelnes Verhalten das Problem. Ziehen an der Leine, ständige Wachsamkeit, viele Umweltreize und die Sorge vor der nächsten Begegnung können sich gegenseitig verstärken.',
                            'Gerade in Hamburg treffen auf einer kurzen Runde häufig Fahrräder, Kinder, Lieferverkehr, enge Wege und andere Hunde zusammen. Deshalb schauen wir im Training auf Route, Tageszeit, Erregungsniveau, Pausen, Abstände und deine Handlungsmöglichkeiten.',
                        ],
                    ],
                    [
                        'question' => 'Helfen kürzere oder ruhigere Runden?',
                        'answer' => [
                            'Ja. Eine kürzere Runde zu einer ruhigeren Zeit kann vorübergehend deutlich sinnvoller sein als ein langer Spaziergang mit zu vielen schwierigen Situationen.',
                            'Das bedeutet nicht, problematischen Situationen für immer auszuweichen. Zunächst wird der Alltag so gestaltet, dass dein Hund wieder lernen und sich erholen kann. Anschließend können Anforderungen kontrolliert aufgebaut werden.',
                        ],
                    ],
                    [
                        'question' => 'Hilft mehr Auslastung gegen Aufregung beim Spaziergang?',
                        'answer' => [
                            'Nicht automatisch. Ein Hund, der bereits dauerhaft aufgeregt ist, profitiert nicht zwingend von noch mehr Bewegung oder intensiver Beschäftigung.',
                            'Häufig sind passende Ruhephasen, vorhersehbare Abläufe, Schnüffelmöglichkeiten und eine an den Hund angepasste Umgebung hilfreicher. Ziel ist nicht, den Hund möglichst müde zu machen, sondern seine Regulationsfähigkeit zu verbessern.',
                        ],
                    ],
                    [
                        'question' => 'Was mache ich, wenn mir ein Spaziergang zu viel wird?',
                        'answer' => [
                            'Wähle zunächst ruhigere Wege, kürzere Runden oder Zeiten mit weniger Begegnungsverkehr. Geplante Pausen und mehr Abstand zu schwierigen Situationen können den Alltag unmittelbar entlasten.',
                            'Im Training entwickeln wir konkrete Strategien für typische Auslöser und bauen die Anforderungen anschließend kontrolliert wieder auf.',
                        ],
                    ],
                    [
                        'question' => 'Können Schmerzen das Verhalten beim Spaziergang beeinflussen?',
                        'answer' => [
                            'Ja. Schmerzen oder andere körperliche Beschwerden können dazu führen, dass Hunde schneller gereizt, unsicher oder abwehrend reagieren.',
                            'Wenn sich das Verhalten plötzlich verändert, ungewöhnlich stark wird oder ohne erkennbaren Grund auftritt, sollte der Hund tierärztlich untersucht werden.',
                        ],
                    ],
                    [
                        'question' => 'Wie erkenne ich erste Fortschritte?',
                        'answer' => [
                            'Fortschritt bedeutet nicht nur, dass dein Hund sofort ruhig an jedem Auslöser vorbeigeht. Frühe Veränderungen können sein: dein Hund bleibt länger ansprechbar, er beruhigt sich schneller, du erkennst Anspannung früher, ihr könnt mehr Abstand halten oder schwierige Situationen treten seltener auf.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'hundebegegnungen',
                'nav_label' => 'Hundebegegnungen',
                'title' => 'Hundebegegnungen',
                'intro' => [
                    'Bellen, Fixieren, in die Leine springen oder hektisches Ausweichen können unterschiedliche Ursachen haben. Manche Hunde sind unsicher, andere frustriert oder bereits so aufgeregt, dass sie kaum noch ansprechbar sind.',
                    'Im Einzeltraining schauen wir deshalb nicht nur auf das sichtbare Verhalten. Entscheidend ist, wann die Anspannung beginnt, welche Signale dein Hund vorher zeigt und unter welchen Bedingungen er noch lernen kann.',
                ],
                'questions' => [
                    [
                        'question' => 'Warum reagiert mein Hund bei Begegnungen so stark?',
                        'answer' => [
                            'Bellen, Fixieren, in die Leine springen oder hektisches Ausweichen können unterschiedliche Ursachen haben. Manche Hunde sind unsicher, andere frustriert oder bereits so aufgeregt, dass sie kaum noch ansprechbar sind.',
                            'Auch schlechte Erfahrungen, Schmerzen oder ein zu geringer Abstand können eine Rolle spielen. Im Einzeltraining schauen wir deshalb nicht nur auf das sichtbare Verhalten, sondern auf Auslöser, Anspannung und Trainingsbedingungen.',
                        ],
                    ],
                    [
                        'question' => 'Was mache ich auf einem engen Gehweg im Hamburger Kiez?',
                        'answer' => [
                            'Auf schmalen Gehwegen lässt sich eine Begegnung nicht immer in Ruhe vorbereiten. Dann ist gutes Management wichtiger als eine perfekte Trainingsübung.',
                            'Je nach Situation kann es sinnvoll sein, frühzeitig die Straßenseite zu wechseln, in eine Einfahrt oder einen Hauseingang auszuweichen, einen Bogen zu laufen, Sichtschutz zu nutzen oder umzudrehen, bevor dein Hund überfordert ist.',
                        ],
                    ],
                    [
                        'question' => 'Muss mein Hund lernen, direkt an anderen Hunden vorbeizugehen?',
                        'answer' => [
                            'Nicht sofort. Das erste Ziel kann sein, einen anderen Hund aus größerer Entfernung wahrzunehmen und trotzdem ansprechbar zu bleiben. Erst wenn das zuverlässig gelingt, wird der Abstand schrittweise verringert.',
                            'Ein realistischer Trainingsweg orientiert sich am aktuellen Stand deines Hundes und nicht daran, wie eine Begegnung idealerweise aussehen sollte.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'stress-belebte-umgebung',
                'nav_label' => 'Stress in belebter Umgebung',
                'title' => 'Stress in belebter Umgebung',
                'intro' => [
                    'Ein Hund muss sich nicht grundsätzlich an Stadtlärm oder viele Reize gewöhnen, indem er ihnen einfach möglichst oft ausgesetzt wird. Wir arbeiten lieber so, dass er Situationen wahrnehmen kann, ohne dauerhaft überfordert zu sein.',
                    'Dazu wählen wir einen Abstand und eine Umgebung, in der dein Hund noch lernfähig bleibt. Von dort aus wird die Schwierigkeit langsam gesteigert.',
                ],
                'questions' => [
                    [
                        'question' => 'Woran erkenne ich, dass mein Hund draußen überfordert ist?',
                        'answer' => [
                            'Überforderung zeigt sich nicht bei jedem Hund gleich. Mögliche Signale sind starkes Hecheln ohne körperliche Anstrengung, hektisches Scannen der Umgebung, dauerhaftes Ziehen, häufiges Schütteln oder Kratzen, Futterverweigerung, Erstarren, plötzliches Bellen oder Anspringen sowie kaum mögliche Kontaktaufnahme.',
                            'Ein einzelnes Signal ist nicht immer eindeutig. Wichtig sind Häufigkeit, Situation und die gesamte Körpersprache.',
                        ],
                    ],
                    [
                        'question' => 'Kann ein Hund lernen, mit Stadtlärm und vielen Reizen besser umzugehen?',
                        'answer' => [
                            'Häufig ja, allerdings nicht durch möglichst viel Konfrontation. Lernen gelingt besser, wenn die Reize dosiert werden und dein Hund zwischendurch ausreichend Ruhe bekommt.',
                            'Wir wählen einen Abstand und eine Umgebung, in der dein Hund die Situation wahrnehmen kann, ohne dauerhaft überfordert zu sein. Von dort aus wird die Schwierigkeit langsam gesteigert.',
                        ],
                    ],
                    [
                        'question' => 'Muss das Training mitten in der Innenstadt stattfinden?',
                        'answer' => [
                            'Nicht zu Beginn. Ein Training startet dort, wo dein Hund noch ansprechbar ist. Das kann eine ruhigere Seitenstraße, ein größerer Abstand oder eine weniger belebte Uhrzeit sein.',
                            'Das Ziel ist nicht, deinen Hund sofort der schwierigsten Umgebung auszusetzen, sondern ihn schrittweise darauf vorzubereiten.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'rueckruf-unter-ablenkung',
                'nav_label' => 'Rückruf unter Ablenkung',
                'title' => 'Rückruf unter Ablenkung',
                'intro' => [
                    'Ein Rückruf muss auch dann funktionieren, wenn draußen deutlich mehr los ist als im Wohnzimmer. Deshalb wird er schrittweise und mit klarer Sicherung aufgebaut.',
                    'Für den Aufbau kann eine Schleppleine sinnvoll sein. Sie verhindert, dass dein Hund sich durch Weglaufen selbst belohnt, und ermöglicht kontrollierte Wiederholungen.',
                ],
                'questions' => [
                    [
                        'question' => 'Warum funktioniert der Rückruf zu Hause, aber draußen nicht?',
                        'answer' => [
                            'Zu Hause konkurriert dein Signal mit wenigen Ablenkungen. Draußen können Gerüche, Wildspuren, andere Hunde oder Bewegungsreize deutlich interessanter sein.',
                            'Ein Rückruf muss deshalb in verschiedenen Schwierigkeitsstufen aufgebaut werden. Erst wenn er unter leichter Ablenkung zuverlässig funktioniert, wird die Situation anspruchsvoller.',
                        ],
                    ],
                    [
                        'question' => 'Wie trainiere ich den Rückruf sicher?',
                        'answer' => [
                            'Für den Aufbau kann eine Schleppleine sinnvoll sein. Sie verhindert, dass dein Hund sich durch Weglaufen selbst belohnt, und ermöglicht kontrollierte Wiederholungen.',
                            'Dabei muss die Schleppleine passend verwendet und an einem gut sitzenden Geschirr befestigt werden. Im Einzeltraining klären wir, welche Sicherung zu deinem Hund und eurem Umfeld passt.',
                        ],
                    ],
                    [
                        'question' => 'Wann kann mein Hund wieder frei laufen?',
                        'answer' => [
                            'Freilauf sollte erst dann erfolgen, wenn der Rückruf unter den zu erwartenden Ablenkungen ausreichend zuverlässig ist und die Umgebung es erlaubt.',
                            'Auch mit gutem Training bleibt verantwortungsvolles Management wichtig. In unübersichtlichen Gebieten, bei starkem Jagdverhalten oder in der Nähe von Straßen kann eine Schleppleine weiterhin die bessere Lösung sein.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'unsicherheit-hundehalter',
                'nav_label' => 'Unsicherheit als Hundehalter',
                'title' => 'Unsicherheit als Hundehalter',
                'intro' => [
                    'Unsicherheit entsteht häufig, wenn Situationen wiederholt schwierig waren oder viele widersprüchliche Ratschläge zusammenkommen. Dann wird selbst eine kleine Entscheidung auf dem Spaziergang anstrengend.',
                    'Im Einzeltraining sortieren wir zunächst, was tatsächlich relevant ist. Du bekommst wenige, klare Handlungsschritte und Kriterien, an denen du dich orientieren kannst.',
                ],
                'questions' => [
                    [
                        'question' => 'Was kann ich tun, wenn ich meinem eigenen Verhalten nicht mehr vertraue?',
                        'answer' => [
                            'Unsicherheit entsteht häufig, wenn Situationen wiederholt schwierig waren oder viele widersprüchliche Ratschläge zusammenkommen. Dann wird selbst eine kleine Entscheidung auf dem Spaziergang anstrengend.',
                            'Im Einzeltraining sortieren wir zunächst, was tatsächlich relevant ist. Du bekommst wenige, klare Handlungsschritte und Kriterien, an denen du dich orientieren kannst.',
                        ],
                    ],
                    [
                        'question' => 'Muss ich immer ruhig und souverän sein?',
                        'answer' => [
                            'Nein. Niemand reagiert in jeder Situation perfekt. Entscheidend ist nicht, Unsicherheit zu verstecken, sondern einen Plan zu haben, der auch unter Stress umsetzbar bleibt.',
                            'Dazu gehören einfache Signale, rechtzeitiges Ausweichen und realistische Erwartungen an dich und deinen Hund.',
                        ],
                    ],
                    [
                        'question' => 'Werde ich im Training bewertet?',
                        'answer' => [
                            'Nein. Schwierigkeiten mit einem Hund sind kein persönliches Versagen. Wir schauen sachlich darauf, was bisher passiert ist, was bereits funktioniert und wo eine Veränderung hilfreich wäre.',
                            'Gute Begleitung soll dir Sicherheit geben, nicht zusätzlichen Druck erzeugen.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'trainingsansaetze-ohne-erfolg',
                'nav_label' => 'Trainingsansätze ohne Erfolg',
                'title' => 'Verschiedene Trainingsansätze ohne Erfolg',
                'intro' => [
                    'Ein Tipp kann grundsätzlich sinnvoll sein und trotzdem nicht zu eurer Situation passen. Häufig fehlen wichtige Informationen über Auslöser, Abstand, Erregungsniveau, Timing oder die Funktion des Verhaltens.',
                    'Im Einzeltraining übernehmen wir, was bereits funktioniert, und verändern nur die Teile, die euch nicht weiterbringen.',
                ],
                'questions' => [
                    [
                        'question' => 'Warum haben bisherige Tipps bei uns nicht funktioniert?',
                        'answer' => [
                            'Ein Tipp kann grundsätzlich sinnvoll sein und trotzdem nicht zu eurer Situation passen. Häufig fehlen wichtige Informationen über Auslöser, Abstand, Erregungsniveau, Timing oder die Funktion des Verhaltens.',
                            'Manchmal waren die Trainingsschritte zu groß, die Umgebung zu schwierig oder die Übung im Alltag nicht konsequent umsetzbar. Deshalb prüfen wir nicht nur, was du versucht hast, sondern auch wie und unter welchen Bedingungen.',
                        ],
                    ],
                    [
                        'question' => 'Muss ich im Einzeltraining wieder ganz von vorne anfangen?',
                        'answer' => [
                            'Nicht unbedingt. Wir übernehmen, was bereits funktioniert, und verändern nur die Teile, die euch nicht weiterbringen.',
                            'Vorhandene Signale, Routinen und Erfahrungen sind wichtige Informationen. Ziel ist kein kompletter Neustart, sondern ein verständlicher und konsistenter Trainingsweg.',
                        ],
                    ],
                    [
                        'question' => 'Was sollte ich zum ersten Termin mitbringen?',
                        'answer' => [
                            'Hilfreich sind kurze Notizen zu bisherigen Trainingsansätzen: Welche Methode oder Übung wurde ausprobiert, wie lange wurde sie angewendet, in welchen Situationen funktionierte sie und wann funktionierte sie nicht?',
                            'Auch hilfreich ist, wie dein Hund reagierte und was für dich schwer umsetzbar war. So lässt sich schneller erkennen, wo der bisherige Ansatz angepasst werden sollte.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'alltagstauglicher-trainingsplan',
                'nav_label' => 'Alltagstauglicher Trainingsplan',
                'title' => 'Alltagstauglicher Trainingsplan',
                'intro' => [
                    'Ein guter Trainingsplan enthält keine lange Sammlung allgemeiner Übungen. Er beschreibt wenige konkrete Schritte, die zu eurem Tagesablauf, eurem Wohnumfeld und den Möglichkeiten deines Hundes passen.',
                    'Regelmäßigkeit ist wichtig, aber Erholung gehört ebenfalls zum Trainingsplan.',
                ],
                'questions' => [
                    [
                        'question' => 'Wie sieht ein alltagstauglicher Trainingsplan aus?',
                        'answer' => [
                            'Ein guter Trainingsplan enthält keine lange Sammlung allgemeiner Übungen. Er beschreibt wenige konkrete Schritte: welches Verhalten trainiert wird, in welcher Umgebung geübt wird, wie häufig und wie lange, woran du einen passenden Schwierigkeitsgrad erkennst und wann der nächste Schritt möglich ist.',
                            'Der Plan muss zu deinem Tagesablauf, deinem Wohnumfeld und den Möglichkeiten deines Hundes passen.',
                        ],
                    ],
                    [
                        'question' => 'Muss ich jeden Tag lange trainieren?',
                        'answer' => [
                            'Nein. Kurze, gut vorbereitete Einheiten sind häufig wirksamer als seltene, lange Trainingseinheiten. Viele Übungen lassen sich direkt in Spaziergänge oder tägliche Abläufe integrieren.',
                            'Regelmäßigkeit ist wichtig, aber Erholung gehört ebenfalls zum Trainingsplan.',
                        ],
                    ],
                    [
                        'question' => 'Was passiert, wenn der Plan im Alltag nicht funktioniert?',
                        'answer' => [
                            'Dann wird er angepasst. Ein Trainingsplan ist kein starres Programm. Wenn eine Übung zu kompliziert ist, dein Hund regelmäßig überfordert wird oder die Umsetzung im Alltag nicht realistisch ist, verändern wir Bedingungen oder Zwischenschritte.',
                            'Der Plan soll euch unterstützen und nicht zu einer zusätzlichen Belastung werden.',
                        ],
                    ],
                ],
            ],
            [
                'id' => 'aggressives-verhalten',
                'nav_label' => 'Aggressives Verhalten',
                'title' => 'Hunde mit aggressivem Verhalten',
                'intro' => [
                    'Hunde mit aggressivem Verhalten betreuen wir ausschließlich nach vorheriger Absprache und individueller Einschätzung.',
                    'Bitte schildere uns bereits bei deiner Anfrage möglichst genau, gegen wen sich das Verhalten richtet, in welchen Situationen es auftritt, ob es bereits Schnapp- oder Beißvorfälle gab und wie die bisherige Sicherung aussieht.',
                ],
                'notice' => 'Training nur nach vorheriger Absprache.',
                'questions' => [
                    [
                        'question' => 'Trainiert ihr auch Hunde mit aggressivem Verhalten?',
                        'answer' => [
                            'Ja, aber nur nach vorheriger Absprache und individueller Einschätzung. Diese Informationen helfen uns, einzuschätzen, ob und unter welchen Sicherheitsbedingungen ein Training möglich ist.',
                        ],
                    ],
                    [
                        'question' => 'Bedeutet aggressives Verhalten, dass mein Hund gefährlich oder böse ist?',
                        'answer' => [
                            'Nein. Aggressionsverhalten ist zunächst Teil des natürlichen Verhaltensrepertoires eines Hundes. Es kann unter anderem durch Angst, Schmerzen, Unsicherheit, Ressourcenverteidigung, Frustration oder erlernte Erfahrungen ausgelöst werden.',
                            'Das Verhalten muss dennoch ernst genommen werden. Entscheidend sind Auslöser, Intensität, Vorhersagbarkeit, Vorgeschichte und das konkrete Risiko für Menschen und Tiere.',
                        ],
                    ],
                    [
                        'question' => 'Was passiert vor dem ersten Training?',
                        'answer' => [
                            'Vor dem praktischen Training führen wir ein ausführliches Erstgespräch. Dabei erfassen wir die Vorgeschichte, bekannte Auslöser, bisherige Vorfälle, das aktuelle Management und die Trainingsziele.',
                            'Anschließend entscheiden wir, welches Setting sicher und sinnvoll ist. Das erste Treffen findet gegebenenfalls ohne direkten Kontakt, mit großem Abstand oder an einem kontrollierten Ort statt.',
                        ],
                    ],
                    [
                        'question' => 'Ist ein Maulkorb erforderlich?',
                        'answer' => [
                            'Je nach Vorgeschichte und Risikoeinschätzung kann ein geeigneter Maulkorb Voraussetzung für das Training sein. Ein Maulkorb ist keine Strafe, sondern kann Menschen und Tiere schützen und dadurch kontrolliertes Training ermöglichen.',
                            'Der Hund sollte den Maulkorb freiwillig und kleinschrittig kennenlernen.',
                        ],
                    ],
                    [
                        'question' => 'Welche Sicherheitsmaßnahmen können erforderlich sein?',
                        'answer' => [
                            'Abhängig vom Einzelfall können unter anderem ein geeigneter und sicher sitzender Maulkorb, eine stabile Leine und passende Sicherung, ausreichender Abstand zu Auslösern, ein kontrollierter Trainingsort, der Verzicht auf unkontrollierte Kontakte und die Einhaltung bestehender behördlicher Auflagen notwendig sein.',
                            'Außerdem kann eine tierärztliche oder verhaltensmedizinische Abklärung sinnvoll sein. Das konkrete Sicherheitskonzept wird individuell festgelegt.',
                        ],
                    ],
                    [
                        'question' => 'Kann jedes Aggressionsproblem gelöst werden?',
                        'answer' => [
                            'Seriös kann dies nicht pauschal versprochen werden. Häufig lassen sich Sicherheit, Ansprechbarkeit und Alltagssituationen deutlich verbessern. Das Ergebnis hängt jedoch von vielen Faktoren ab.',
                            'Das erste Ziel besteht immer darin, Risiken zu reduzieren und wieder kontrollierbare Situationen zu schaffen.',
                        ],
                    ],
                    [
                        'question' => 'Was sollte ich bei einem akuten Beißrisiko tun?',
                        'answer' => [
                            'Vermeide weitere unkontrollierte Situationen und sichere deinen Hund so, dass weder Menschen noch andere Tiere gefährdet werden. Erzwinge keine Begegnungen oder körperlichen Auseinandersetzungen.',
                            'Bei einer unmittelbaren Gefahr, schweren Verletzungen oder einem nicht sicher kontrollierbaren Hund sollten zusätzlich geeignete örtliche Fachstellen, eine Tierarztpraxis beziehungsweise eine tierärztliche Verhaltenstherapie kontaktiert werden.',
                        ],
                    ],
                ],
            ],
        ];
    }
}

if (! function_exists('bsh_faq_topic_slug')) {
    function bsh_faq_topic_slug(array $topic): string
    {
        return $topic['id'] ?? '';
    }
}

if (! function_exists('bsh_faq_render_parts')) {
    function bsh_faq_render_parts(array $parts): string
    {
        return implode("\n", array_map(
            static fn ($part): string => '<p>' . wp_kses_post($part) . '</p>',
            $parts
        ));
    }
}

if (! function_exists('bsh_faq_render_answer')) {
    function bsh_faq_render_answer(array $parts): string
    {
        $html = [];

        foreach ($parts as $part) {
            if (str_starts_with(trim((string) $part), '<ul') || str_starts_with(trim((string) $part), '<ol') || str_starts_with(trim((string) $part), '<blockquote')) {
                $html[] = wp_kses_post((string) $part);
                continue;
            }

            $html[] = '<p>' . wp_kses_post((string) $part) . '</p>';
        }

        return implode("\n", $html);
    }
}

if (! function_exists('bsh_faq_render_question')) {
    function bsh_faq_render_question(array $question, string $topic_id, int $index): string
    {
        $item_id = $topic_id . '-question-' . ($index + 1);

        return sprintf(
            '<details class="faq-item" id="%1$s"><summary><span class="faq-question">%2$s</span><span class="faq-icon" aria-hidden="true"></span></summary><div class="faq-answer"><div class="faq-answer__inner">%3$s</div></div></details>',
            esc_attr($item_id),
            esc_html($question['question']),
            bsh_faq_render_answer($question['answer'])
        );
    }
}

if (! function_exists('bsh_faq_render_topic')) {
    function bsh_faq_render_topic(array $topic): string
    {
        $topic_id = bsh_faq_topic_slug($topic);
        $heading_id = 'faq-topic-' . $topic_id;
        $parts = [];

        $parts[] = sprintf(
            '<section id="%1$s" class="faq-topic" aria-labelledby="%2$s"><h2 id="%2$s" tabindex="-1">%3$s</h2>',
            esc_attr($topic_id),
            esc_attr($heading_id),
            esc_html($topic['title'])
        );

        foreach ($topic['intro'] ?? [] as $paragraph) {
            $parts[] = '<p class="faq-topic__intro">' . wp_kses_post($paragraph) . '</p>';
        }

        if (! empty($topic['steps'])) {
            $parts[] = '<ol class="faq-process">';
            foreach ($topic['steps'] as $step) {
                $parts[] = '<li>' . esc_html($step) . '</li>';
            }
            $parts[] = '</ol>';
        }

        if (! empty($topic['notice'])) {
            $parts[] = '<p class="faq-topic__notice">' . esc_html($topic['notice']) . '</p>';
        }

        $parts[] = '<div class="faq-list">';

        foreach ($topic['questions'] as $index => $question) {
            $parts[] = bsh_faq_render_question($question, $topic_id, $index);
        }

        $parts[] = '</div>';

        if (! empty($topic['cta_label']) && ! empty($topic['cta_url'])) {
            $parts[] = sprintf(
                '<div class="faq-topic__cta wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="%1$s">%2$s</a></div></div>',
                esc_url($topic['cta_url']),
                esc_html($topic['cta_label'])
            );
        }

        $parts[] = '</section>';

        return implode("\n", $parts);
    }
}

if (! function_exists('bsh_faq_render_navigation')) {
    function bsh_faq_render_navigation(array $topics): string
    {
        $items = [];

        foreach ($topics as $topic) {
            $items[] = sprintf(
                '<a class="faq-topics-nav__link" href="#%1$s">%2$s</a>',
                esc_attr($topic['id']),
                esc_html($topic['nav_label'])
            );
        }

        return '<nav class="faq-topics-nav" aria-label="Themen in den häufigen Fragen">' . implode('', $items) . '</nav>';
    }
}

if (! function_exists('bsh_faq_schema_json')) {
    function bsh_faq_schema_json(array $topics): string
    {
        $main_entity = [];

        foreach ($topics as $topic) {
            foreach ($topic['questions'] as $question) {
                $main_entity[] = [
                    '@type' => 'Question',
                    'name' => $question['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => trim(wp_strip_all_tags(bsh_faq_render_answer($question['answer']))),
                    ],
                ];
            }
        }

        return wp_json_encode(
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $main_entity,
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}

if (! function_exists('bsh_faq_page_content')) {
    function bsh_faq_page_content(string $hero_image = 'beziehung-hund/entspannung-mit-hund-ruhe-und-vertrauen.png', string $hero_position = '52% center'): string
    {
        $topics = bsh_faq_topics();
        $schema = bsh_faq_schema_json($topics);
        $content = [];
        $content[] = '<div class="bsh-faq-page">';
        $content[] = '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-page-intro bsh-faq-intro","layout":{"type":"constrained"}} -->';
        $content[] = '<section class="wp-block-group bsh-section bsh-page-intro bsh-faq-intro">';
        $content[] = '<!-- wp:html -->';
        $content[] = '<div class="bsh-eyebrow">FAQ</div>';
        $content[] = '<!-- /wp:html -->';
        $content[] = '<!-- wp:heading {"level":1,"className":"bsh-page-intro__title"} -->';
        $content[] = '<h1 class="wp-block-heading bsh-page-intro__title">Häufige Fragen</h1>';
        $content[] = '<!-- /wp:heading -->';
        $content[] = '<!-- wp:paragraph {"className":"bsh-page-intro__lead"} -->';
        $content[] = '<p class="bsh-page-intro__lead">Jeder Hund und jedes Mensch-Hund-Team bringt eigene Erfahrungen, Bedürfnisse und Herausforderungen mit. Deshalb gibt es im Training selten eine Lösung, die für alle gleichermaßen funktioniert.</p>';
        $content[] = '<!-- /wp:paragraph -->';
        $content[] = '<!-- wp:list {"className":"bsh-page-intro__outline"} -->';
        $content[] = '<ul class="wp-block-list bsh-page-intro__outline">';
        $content[] = '<li>Typische Fragen rund um Einstieg und Ablauf</li>';
        $content[] = '<li>Einordnung von Alltag, Verhalten und Trainingsweg</li>';
        $content[] = '<li>Klarer nächster Schritt statt allgemeiner Floskeln</li>';
        $content[] = '</ul>';
        $content[] = '<!-- /wp:list -->';
        $content[] = '</section>';
        $content[] = '<!-- /wp:group -->';

        $content[] = '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft faq-intro","layout":{"type":"constrained"}} -->';
        $content[] = '<section class="wp-block-group bsh-section bsh-section--soft faq-intro">';
        $content[] = '<!-- wp:paragraph -->';
        $content[] = '<p>In einem persönlichen Erstgespräch schauen wir uns eure Situation genau an und entwickeln einen Trainingsweg, der zu eurem Alltag, eurem Hund und euren Zielen passt.</p>';
        $content[] = '<!-- /wp:paragraph -->';
        $content[] = '</section>';
        $content[] = '<!-- /wp:group -->';

        $content[] = bsh_image_gallery_section(
            'Fragen mit Kontext',
            'Die FAQ-Seite bekommt bewusst ein ruhiges Bild zwischen Einordnung und Fragekatalog, damit der Uebergang nicht nur aus Text besteht.',
            [
                ['slug' => 'beziehung-hund-vertrauen-blickkontakt-hundetraining', 'alt' => 'Blickkontakt und Vertrauen zwischen Mensch und Hund', 'eager' => true],
            ]
        );

        $content[] = bsh_faq_render_navigation($topics);

        foreach ($topics as $topic) {
            $content[] = bsh_faq_render_topic($topic);
        }

        $content[] = '<section class="wp-block-group bsh-section bsh-section--accent faq-contact-cta">';
        $content[] = '<h2>Du bist unsicher, welches Training zu euch passt?</h2>';
        $content[] = '<p>Beschreibe uns deine Situation über das Kontaktformular, per E-Mail, telefonisch oder über WhatsApp. Bei Hunden mit aggressivem Verhalten oder bekannten Beißvorfällen ist eine vorherige Absprache zwingend erforderlich.</p>';
        $content[] = '<div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/kontakt/">Kontakt aufnehmen</a></div></div>';
        $content[] = '</section>';
        $content[] = '</div>';

        $content[] = '<script type="application/ld+json">' . $schema . '</script>';

        return implode("\n\n", $content);
    }
}
