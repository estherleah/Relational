SELECT userID, COUNT(userID) AS matches
FROM (
  (SELECT DISTINCT userID2 AS userID
  FROM friendship AS fo
  WHERE userID1 IN
    (SELECT userID2
    FROM friendship
    WHERE userID1 = 1)
  AND status = 1
  AND fo.userID2 NOT IN
    (SELECT userID2
    FROM friendship
    WHERE userID1 = 1)
  AND userID2 != 1
  ORDER BY RAND()
  )
UNION ALL
  (SELECT DISTINCT userID
  FROM circle_participants AS c
  WHERE c.circleID IN
    (SELECT circleID
    FROM circle_participants
    WHERE userID = 1)
  AND userID != 1
  AND NOT EXISTS
    (SELECT *
    FROM friendship AS f
    WHERE f.userID1 = 1
    AND f.userID2 = c.userID)
  ORDER BY RAND()
  )
UNION ALL
  (SELECT DISTINCT userID
  FROM user AS u2
  WHERE u2.location IN
    (SELECT location
    FROM user
    WHERE userID = 1)
  AND u2.userID != 1
  AND NOT EXISTS
    (SELECT *
    FROM friendship AS f
    WHERE f.userID1 = 1
    AND f.userID2 = u2.userID)
  ORDER BY RAND()
  )
) result
GROUP BY result.userID
ORDER BY matches DESC;
